<?php

declare(strict_types=1);

namespace Vvintage\Repositories;

use RedBeanPHP\R; // Подключаем readbean
use RedBeanPHP\OODBBean; // для обозначения типа даннных
use Vvintage\Models\User\User;
use Vvintage\Models\Cart\Cart;
use Vvintage\Repositories\AddressRepository;

final class UserRepository
{
    private const TABLE_USERS = 'users';
    private const TABLE_ADDRESSES = 'address';
    private const TABLE_BLOCKED_USERS = 'blockedusers';

    private AddressRepository $addressRepository;

    public function __construct()
    {
      $this->addressRepository = new AddressRepository();
    }

    private function loadBean (string $tableName, int $id): OODBBean
    {
      return R::load($tableName, $id);
    }

    private function saveUser(OODBBean $bean): int
    {
      return R::store($bean);
    }

    private function findUserBeanByEmail(string $tableName, string $email): ?OODBBean
    {
      return R::findOne($tableName, 'email = ?', [strtolower($email)]);
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
    public function findUserById(int $id): ?User
    {
        $bean = $this->loadBean(self::TABLE_USERS, $id);

        if ($bean->id === 0) {
            return null;
        }
        return new User($bean);
    }

    /**
     * Метод ищет пользователя по email
     * @param string $email
     * @return OODBBean
     */
    public function findUserByEmail(string $email): ?User
    {
      $bean = $this->findUserBeanByEmail(self::TABLE_USERS, $email);

      if (!$bean) {
          return null;
      }

      return new User($bean);
    }

    public function findBlockedUserByEmail (string $email): bool 
    {
      $bean = $this->findUserBeanByEmail(self::TABLE_BLOCKED_USERS, $email);
      return $bean ? true : false;
    }

    /**
     * Метод возвращает всех пользователей
     * 
     * @return array
     */
    public function findAll(): array
    {
      return R::findAll(self::TABLE_USERS);
    }



    /**
     * Метод создает нового пользователя 
     * 
     * @return User|null
    */
    public function createUser(array $postData): ?User
    {
      $bean = R::dispense(self::TABLE_USERS);

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

      $userId = $this->saveUser($bean);

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

        $userId = $this->saveUser($bean);
  
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

        $this->saveUser($bean);
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
        $this->saveUser($bean);
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
        $this->saveUser($userBean);
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

      return $this->saveUser($bean);
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
        $this->saveUser($userBean);
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

}
