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
use Vvintage\DTO\User\UserOutputDTO;
use Vvintage\DTO\User\UserCreateDTO;
use Vvintage\DTO\User\UserUpdateDTO;
use Vvintage\DTO\Address\AddressDTO;

final class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    private const TABLE_USERS = 'users';
    private const TABLE_BLOCKED_USERS = 'blockedusers';


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

     /** create DTO */
    private function getUserCreateDto(array $data): UserCreateDTO
    {
  
      $dto = new UserCreateDTO([
                  'password' => (string) $data['password'],
                  'email' => strtolower((string) $data['email']),
                  'name' => null,
                  'role' => (string) 'customer',

                  'fav_list' => json_encode($dto->fav_list ?? []),
                  'cart' => json_encode($dto->cart ?? []),

                  'country' => (string) '',
                  'city' => (string) '',
                  'phone' => (string) '',

                  'avatar' => (string) '',
                  'avatar_small' => (string) ''
              ]);
  
         
      return  $dto;

    }

    private function mapBeanToUser(OODBBean $bean): User
    {
        $dto = new UserOutputDTO([
            'id' => (int) $bean->id,
            'password' => (string) $bean->password,
            'email' => (string) $bean->email,
            'name' => (string) $bean->name,
            'surname' => (string) $bean->surname,
            'role' => (string) $bean->role,

            'fav_list' => (string) $bean->fav_list,
            'cart' => (string) $bean->cart,

            'country' => (string) $bean->country,
            'city' => (string) $bean->city,
            'phone' => (string) $bean->phone,

            'avatar' => (string) $bean->avatar,
            'avatar_small' => (string) $bean->avatar_small,
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
        $beans = $this->findAll(self::TABLE_USERS);

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
      $dto = $this->getUserCreateDto($postData);
      return $this->saveNewUser($dto);
    }

  

  public function saveNewUser(UserCreateDTO $dto): ?User
  {
      $bean = $this->createBean(self::TABLE_USERS);
      $bean->password = $this->hashPassword($dto->password);
      $bean->email = strtolower($dto->email);
      $bean->name = $dto->name ?? '';
      $bean->role = $dto->role && trim($dto->role) !== '' ? $dto->role : 'customer';

      // JSON поля
      $bean->fav_list = json_encode($dto->fav_list ?? []);
      $bean->cart = json_encode($dto->cart ?? []);
      $bean->country = $dto->country ?? '';
      $bean->city = $dto->city ?? '';
      $bean->phone = $dto->phone ?? '';
      $bean->avatar = $dto->avatar ?? '';
      $bean->avatar_small = $dto->avatar_small ?? '';

      $this->saveBean($bean);

      return $this->mapBeanToUser($bean);
  }

  public function updateUser(UserUpdateDTO $dto, int $id): ?User
  {
      $bean = $this->loadBean(self::TABLE_USERS, $id);
      if (!$bean || $bean->id === 0) return null;

      $bean->name = $dto->name ?? $bean->name;
      $bean->fav_list = json_encode($dto->fav_list ?? json_decode($bean->fav_list, true));
      $bean->cart = json_encode($dto->cart ?? json_decode($bean->cart, true));
      $bean->country = $dto->country ?? $bean->country;
      $bean->city = $dto->city ?? $bean->city;
      $bean->phone = $dto->phone ?? $bean->phone;

      // Аватар обновляем только если пришёл новый
      if (!empty($dto->avatar)) {
          $user->avatar = $dto->avatar;
          $user->avatarSmall = $dto->avatarSmall;
      }

      // $bean->avatar = $dto->avatar ?? $bean->avatar;
      // $bean->avatar_small = $dto->avatar_small ?? $bean->avatar_small;

      $this->saveBean($bean);

      return $this->mapBeanToUser($bean);
  }

  
    /**
     * Метод редактирует пользователя 
     * @param User $userModel, array $newUserData
     * @return User|null
     */
    // public function editUser(User $userModel, array $postData): ?User
    // {
    //   $id = $userModel->getId();
    //   $bean = $this->loadBean(self::TABLE_USERS, $id);

    //   if ($bean->id !== 0) {
    //     // Заполнить пар-ры
    //     $bean->name =  $postData['name'] ?? '';
    //     $bean->surname = $postData['surname'] ?? '';
    //     $bean->country = $postData['country'] ?? '';
    //     $bean->city = $postData['city'] ?? '';
    //     $bean->phone = $postData['phone'] ?? '';
    //     $bean->avatar = $postData['avatar'] ?? '';
    //     $bean->avatar_small = $postData['avatar_small'] ?? '';

    //     $userId = $this->saveBean($bean);
  
    //     return new User ($bean);
    //   }

    //   return null;
    // }

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

    
    private function hashPassword(string $password): string
    {
      return password_hash($password, PASSWORD_DEFAULT);
    }


    /**
     * Метод сохраняет id адреса в поле теблицы User
    */
    // public function updateUserAddressId(int $userId, int $addressId): void {
    //   $userBean = $this->loadBean(self::TABLE_USERS, $userId);
    //   $addressBean = $this->loadBean(self::TABLE_ADDRESSES,  $addressId);

    //   if ($userBean->id !== 0) {
    //     $userBean->address = $addressBean;
    //     $this->saveBean($userBean);
    //   }
    // }

    // public function ensureUserHasAddress(User $userModel): ?int
    // {
    //   $bean = $this->loadBean(self::TABLE_USERS, $userModel->getId());

    //   if ($bean->address_id !== null) {
    //     return null;
    //   }

    //   $addressModel = $this->addressRepository->createAddress(); // создаем новый адрес
    //   $addressId = $addressModel->getId();

    //   if (!is_int($addressId) || $addressId === 0) {
    //     return null;
    //   }

    //   $addressBean = $this->loadBean(self::TABLE_ADDRESSES, $addressId);
    //   $bean->address = $addressBean;

    //   return $this->saveBean($bean);
    // }


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
