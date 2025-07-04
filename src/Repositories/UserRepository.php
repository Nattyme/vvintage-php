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
    public function createUser(array $userData): ?User
    {
      $bean = R::dispense( 'users' );

      if ($bean === 0) {
        return null;
      }
    
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
        $bean = R::load('users', $id);
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
     * Метод добавляет товар в корзину
     * @return array
    */
    public function addToUserCart(int $productId, User $userModel): array
    {
        // Расшифровываем корзину из БД, если не пустая
        $userBean = R::load('users', $userModel->getId());
        $currentCart = !empty($userBean->cart) ? json_decode($userBean->cart, true) : [];

        // Добавляем новый товар
        if (!isset($currentCart[$productId])) {
            $currentCart[$productId] = 1;
        }

        // Обновляем корзину в БД
        $userBean->cart = json_encode($currentCart);
        R::store($userBean);

        // Вернем массив новой корзины в модель
        return $currentCart;
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

}
