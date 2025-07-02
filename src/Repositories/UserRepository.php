<?php
declare(strict_types=1);

namespace Vvintage\Repositories;

use RedBeanPHP\R; // Подключаем readbean
use RedBeanPHP\OODBBean; // для обозначения типа даннных
use Vvintage\Models\User\User;
use Vvintage\Models\Cart\Cart;

final class UserRepository 
{
  public function findById (int $id): ?OODBBean {
    $bean = R::load('users', $id);

    if ( !$bean || $bean->id === 0) {
      return null;
    }
    
    return$bean;
  }

  public function findByEmail (string $email): ?OODBBean 
  {
    return R::findOne('users', 'email = ?', [strtolower($email)]);
  }

  public function findAll () {

  }

  public function createUser () {
    
  }

  public function editUser () {

  }

  public function removeUser () {

  }

  public function updateCart (int $userId, array $cartItems): void {
    // Находим bean пользователя по id из модели
    $userBean = R::load('users', $userId);
    
    // Обновляем корзину 
    $userBean->cart = json_encode($cartItems);
    R::store($userBean);
  }

  public function addToCart(int $userId, int $productId):void
  {
    $userBean = R::load('users', $userId);

    // Расшифровываем текущую корзину, если не пустая
    $currentCart = !empty($userBean->cart) ? json_decode($userBean->cart, true) : [];

    // Объединяем текущую корзину с новой
    if(!isset($currentCart[$productId]))
    {
      $currentCart[$productId] = 1; // добавляем новый товар
    }
    $userBean->cart = json_encode($currentCart);
    R::store($userBean);
  }

  public function getUserCart(int $userId) {
    // Находим bean пользователя по id из модели
    $userBean = R::load('users', $userId);

    // Получаем корзину из БД и переводим в массив
    $userCart = !empty($userBean->cart) ? json_decode($userBean->cart, true) : [];
    return $userCart;
  }


 
} 