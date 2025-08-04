<?php

declare(strict_types=1);

namespace Vvintage\Repositories\User;

use RedBeanPHP\R; // Подключаем readbean
use RedBeanPHP\OODBBean; // для обозначения типа даннных

/** Контракты */
use Vvintage\Contracts\User\UserRepositoryInterface;

/** Абстрактный репозиторий */
use Vvintage\Repositories\AbstractRepository;

use Vvintage\Models\User\User;
use Vvintage\Models\Cart\Cart;
use Vvintage\Repositories\Address\AddressRepository;
use Vvintage\DTO\User\UserDTO;
use Vvintage\DTO\Address\AddressDTO;

final class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    private const TABLE_USERS = 'users';
    private const TABLE_ADDRESSES = 'address';
    private const TABLE_BLOCKED_USERS = 'blockedusers';

    private AddressRepository $addressRepository;

    public function __construct()
    {
      $this->addressRepository = new AddressRepository();
    }


    private function hashPassword(string $password): string
    {
      return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Метод ищет пользователя по id
     * @param int $id
     * @return User|null
     */
    public function getUserById(int $id): ?User
    {
        $bean = $this->loadBean(self::TABLE_USERS, $id);

        if ($bean->id === 0) {
            return null;
        }

        return $this->mapBeanToUser($bean);
    }


    /**
     * Метод ищет пользователя по email
     * @param string $email
     * @return OODBBean
     */
    public function getUserByEmail(string $email): ?User
    {
      $bean = $this->findOneBy(self::TABLE_USERS, 'email = ?', [strtolower($email)]);

      if (!$bean) {
          return null;
      }

      return $this->mapBeanToUser($bean);;
    }



    private function mapBeanToUser(OODBBean $bean): User
    {
        // $translations = $this->loadTranslations((int) $bean->id);

        // Получаем AddressDTO
        $addressDTO = null;
        if (!empty($bean->address_id)) {
            $addressDTO = $this->addressRepository->getAddressDTOById((int)$bean->address_id);
        }

        $dto = new UserDTO([
            'id' => (int) $bean->id,
            'password' => (string) $bean->password,
            'email' => (string) $bean->email,
            'name' => (string) $bean->name,
            'role' => (string) $bean->role,

            'fav_list' => (string) $bean->fav_list,
            'cart' => (string) $bean->cart,

            'country' => (string) $bean->country,
            'city' => (string) $bean->city,
            'phone' => (string) $bean->phone,

            'avatar' => (string) $bean->avatar,
            'avatar_small' => (string) $bean->avatar_small,
            'address' => $addressDTO, // передаём объект AddressDTO
        ]);

        return User::fromDTO($dto);
    }


    public function findBlockedUserByEmail (string $email): bool 
    {
      $bean = $this->findOneBy(self::TABLE_BLOCKED_USERS, 'email = ?', [strtolower($email)]);
      return $bean ? true : false;
    }

    /**
     * Метод возвращает всех пользователей
     * 
     * @return array
     */
    public function getAllUsers(): array
    {
        $this->findAll(self::TABLE_USERS);

        if (empty($beans)) {
          return [];
        }

        return array_map([$this, 'mapBeanToUser'], $beans);
    }

    /**
     * Метод создает нового пользователя 
     * 
     * @return User|null
    */
    public function createUser(array $postData): ?User
    {
      $bean = $this->createBean(self::TABLE_USERS);

      $bean->role = 'user';
      $bean->email = strtolower($postData['email']);;

      // Сохраняем пароль в зашифрованном виде функцией password_hash
      $bean->password = $this->hashPassword($postData['password']);

      $fields = ['name', 'surname', 'country', 'city', 'phone', 'avatar', 'avatar_small', 'cart', 'fav_list', 'recovery_code'];
      foreach($fields as $field) {
        $bean->$field = null;
      }
      
      $addressModel = $this->addressRepository->createAddress(); // создаем новый адрес
      $addressId = $addressModel->getId();

      if (!is_int($addressId) || $addressId === 0) {
        return null;
      }

      $addressBean = $this->loadBean(self::TABLE_ADDRESSES, $addressId);
      $bean->address = $addressBean;

      $userId = $this->saveBean($bean);

      return new User ($bean);
    }


    /**
     * Метод редактирует пользователя 
     * @param User $userModel, array $newUserData
     * @return User|null
     */
    public function editUser(User $userModel, array $postData): ?User
    {
      $id = $userModel->getId();
      $bean = $this->loadBean(self::TABLE_USERS, $id);

      if ($bean->id !== 0) {
        // Заполнить пар-ры
        $bean->name =  $postData['name'] ?? '';
        $bean->surname = $postData['surname'] ?? '';
        $bean->country = $postData['country'] ?? '';
        $bean->city = $postData['city'] ?? '';
        $bean->phone = $postData['phone'] ?? '';
        $bean->avatar = $postData['avatar'] ?? '';
        $bean->avatar_small = $postData['avatar_small'] ?? '';

        $userId = $this->saveBean($bean);
  
        return new User ($bean);
      }

      return null;
    }

    public function setRecoveryCode (User $userModel, string $recoveryCode): void
    {
      $id = $userModel->getId();
      $bean = $this->loadBean(self::TABLE_USERS, $id);

      if ($bean->id !== 0) {
        $bean->recovery_code = $recoveryCode;

        $this->saveBean($bean);
      }
    }

    public function getRecoveryCode (User $userModel): ?string
    {
      $id = $userModel->getId();
      $bean = $this->loadBean(self::TABLE_USERS, $id);

      if ($bean->id !== 0) {
        return $bean->recovery_code;
      }

      return null;
    }

    public function updateUserPassword (User $userModel, string $password): void
    {
      $id = $userModel->getId();
      $bean = $this->loadBean(self::TABLE_USERS, $id);

      if ($bean->id !== 0) {
        $bean->password = $this->hashPassword($password);
        $this->saveBean($bean);
      }
    }

    /**
     * Метод сохраняет id адреса в поле теблицы User
    */
    public function updateUserAddressId(int $userId, int $addressId): void {
      $userBean = $this->loadBean(self::TABLE_USERS, $userId);
      $addressBean = $this->loadBean(self::TABLE_ADDRESSES,  $addressId);

      if ($userBean->id !== 0) {
        $userBean->address = $addressBean;
        $this->saveBean($userBean);
      }
    }

    public function ensureUserHasAddress(User $userModel): ?int
    {
      $bean = $this->loadBean(self::TABLE_USERS, $userModel->getId());

      if ($bean->address_id !== null) {
        return null;
      }

      $addressModel = $this->addressRepository->createAddress(); // создаем новый адрес
      $addressId = $addressModel->getId();

      if (!is_int($addressId) || $addressId === 0) {
        return null;
      }

      $addressBean = $this->loadBean(self::TABLE_ADDRESSES, $addressId);
      $bean->address = $addressBean;

      return $this->saveBean($bean);
    }


  
    /**
     * Метод обновляет корзину
     * @return void
     */
    public function saveUserItemsList(string $itemKey, User $userModel, array $items): void
    {
        // Находим bean пользователя по id из модели
        $userId = $userModel->getId();
        $userBean = $this->loadBean(self::TABLE_USERS, $userId);

        // Обновляем корзину
        $userBean->$itemKey = json_encode($items);
        $this->saveBean($userBean);
    }


    /**
     * Метод удаления пользователя 
     * 
     * @return void
    */
    public function removeUser(User $userModel): void
    {
      $id = $userModel->getId();
      $bean = $this->loadBean(self::TABLE_USERS, $id);

      if ($bean->id !== 0) {
        R::trash( $bean ); 
      }

    }


    /**
     * Метод возвращает корзину user из БД
     * @return array
    */
    public function getItemsList(int $userId, string $itemsKey): array
    {
        // Находим bean пользователя по id из модели
        $bean = $this->loadBean(self::TABLE_USERS, $userId);

        // Получаем корзину из БД и переводим в массив
        $userItems = !empty($bean->$itemsKey) ? json_decode($bean->$itemsKey, true) : [];
        return $userItems;
    }

    public function getAllUsersCount(?string $sql = null, array $params = []): int
    {
      return $this->countAll('users', $sql, $params);
    }
}
