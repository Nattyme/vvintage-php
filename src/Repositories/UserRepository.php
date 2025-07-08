<?php

declare(strict_types=1);

namespace Vvintage\Repositories;

use RedBeanPHP\R; // Подключаем readbean
use RedBeanPHP\OODBBean; // для обозначения типа даннных
use Vvintage\Models\User\User;
use Vvintage\Models\Cart\Cart;

final class UserRepository
{
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

      if ($bean === 0) {
        return null;
      }

      $bean->email = $postData['email'];
      $bean->role = 'user';

      // Сохраняем пароль в зашифрованном виде функцией password_hash
      $bean->password = password_hash($postData['password'], PASSWORD_DEFAULT);

      $userId = R::store($bean);
   
      return new User ($bean);
    }

    /**
     * Метод редактирует пользователя 
     * @param User $userModel, array $newUserData
     * @return User|null
     */
    public function editUser(User $userModel, array $newUserData): ?User
    {
      $id = $userModel->getId();
      $bean = R::load('users', $id);

      if ($bean->id !== 0) {
        // Заполнить пар-ры
        // $userBean->name = $newUserData['name'];
        R::store( $bean );
        return new User ($bean);
      }

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
     * Метод обновляет корзину
     * @return void
     */
    public function saveUserCart(User $userModel, array $cartItems): void
    {
        // Находим bean пользователя по id из модели
        $userId = $userModel->getId();
        $userBean = R::load('users', $userId);

        // Обновляем корзину
        $userBean->cart = json_encode($cartItems);
        R::store($userBean);
    }

    /**
     * Метод возвращает корзину user из БД
     * @return array
    */
    public function getUserCart(int $userId): array
    {
        // Находим bean пользователя по id из модели
        $userBean = R::load('users', $userId);

        // Получаем корзину из БД и переводим в массив
        $userCart = !empty($userBean->cart) ? json_decode($userBean->cart, true) : [];
        return $userCart;
    }

    public function removeCartItem(int $itemId)
    {
      $bean = R::load('users', $itemId);

      if ($bean->id !== 0) {
        R::trash( $bean ); 
      }
    }

}
