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
    private AddressRepository $addressRepository;

    public function __construct()
    {
      $this->addressRepository = new AddressRepository();
    }

    /**
     * Метод ищет пользователя по id
     * @param int $id
     * @return User|null
     */
    public function findUserById(int $id): ?User
    {
        $bean = R::load('users', $id);

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
      $bean = R::findOne('users', 'email = ?', [strtolower($email)]);

      if (!$bean) {
          return null;
      }

      return new User($bean);
    }

    public function findBlockedUserByEmail (string $email): bool 
    {
      $bean  = R::findOne('blockedusers', ' email = ? ', [ strtolower($email) ]);
      return $bean ? true : false;
    }

    /**
     * Метод возвращает всех пользователей
     * 
     * @return array
     */
    public function findAll(): array
    {
      return R::findAll( 'users' );
    }



    /**
     * Метод создает нового пользователя 
     * 
     * @return User|null
    */
    public function createUser(array $postData): ?User
    {
      $bean = R::dispense( 'users' );

      $bean->role = 'user';
      $bean->email = $postData['email'];

      // Сохраняем пароль в зашифрованном виде функцией password_hash
      $bean->password = password_hash($postData['password'], PASSWORD_DEFAULT);

      $bean->name = null;
      $bean->cart = null;
      $bean->fav_list = null;
      $bean->surname = null;
      $bean->country = null;
      $bean->city = null;
      $bean->phone = null;
      $bean->avatar = null;
      $bean->avatar_small = null;
      $bean->recovery_code = null;
      
      $addressModel = $this->addressRepository->createAddress(); // создаем новый адрес
      $addressId = $addressModel->getId();

      if (!is_int($addressId) || $addressId === 0) {
        return null;
      }

      $addressBean = R::load('address', $addressId);
      $bean->address = $addressBean;

      $userId = R::store($bean);

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
      $bean = R::load('users', $id);

      if ($bean->id !== 0) {
        // Заполнить пар-ры
        $bean->name =  $postData['name'] ?? '';
        $bean->surname = $postData['surname'] ?? '';
        $bean->country = $postData['country'] ?? '';
        $bean->city = $postData['city'] ?? '';
        $bean->phone = $postData['phone'] ?? '';
        $bean->avatar = $postData['avatar'] ?? '';
        $bean->avatar_small = $postData['avatar_small'] ?? '';

        $userId = R::store($bean);
    
        R::store( $bean );

        return new User ($bean);
      }

      return null;
    }

    public function setRecoveryCode (User $userModel, string $recoveryCode): void
    {
      $id = $userModel->getId();
      $bean = R::load('users', $id);

      if ($bean->id !== 0) {
        $bean->recovery_code = $recoveryCode;

        R::store( $bean );
      }
    }

    public function getRecoveryCode (User $userModel): ?string
    {
      $id = $userModel->getId();
      $bean = R::load('users', $id);

      if ($bean->id !== 0) {
        return $bean->recovery_code;
      }

      return null;
    }

    public function updateUserPassword (User $userModel, string $password): void
    {
      $id = $userModel->getId();
      $bean = R::load('users', $id);

      if ($bean->id !== 0) {
        $bean->password = password_hash($password, PASSWORD_DEFAULT);
        R::store( $bean );
      }
    }

    /**
     * Метод сохраняет id адреса в поле теблицы User
    */
    public function updateUserAddressId(int $userId, int $addressId): void {
      $userBean = R::load('users', $userId);
      $addressBean = R::load('address',  $addressId);

      if ($userBean->id !== 0) {
        $userBean->address = $addressBean;
        R::store( $userBean);
      }
    }

  
    /**
     * Метод обновляет корзину
     * @return void
     */
    public function saveUserItemsList($itemKey, User $userModel, array $items): void
    {
        // Находим bean пользователя по id из модели
        $userId = $userModel->getId();
        $userBean = R::load('users', $userId);

        // Обновляем корзину
        $userBean->$itemKey = json_encode($items);
        R::store($userBean);
    }

    public function saveUserFav(User $userModel, array $favItems): void
    {
        // Находим bean пользователя по id из модели
        $userId = $userModel->getId();
        $userBean = R::load('users', $userId);

        // Обновляем корзину
        $userBean->fav_list = json_encode($favItems);
        R::store($userBean);
    }


    /**
     * Метод удаления пользователя 
     * 
     * @return void
    */
    public function removeUser(User $userModel): void
    {
      $id = $userModel->getId();
      $bean = R::load('users', $id);

      if ($bean->id !== 0) {
        R::trash( $bean ); 
      }

    }


    /**
     * Метод возвращает корзину user из БД
     * @return array
    */
    // public function getUserCart(int $userId): array
    // {
    //     // Находим bean пользователя по id из модели
    //     $userBean = R::load('users', $userId);

    //     // Получаем корзину из БД и переводим в массив
    //     $userCart = !empty($userBean->cart) ? json_decode($userBean->cart, true) : [];
    //     return $userCart;
    // }

}
