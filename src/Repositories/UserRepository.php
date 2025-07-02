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

  public function updateCart (int $userId, array $cartItems): void {
    // Находим bean пользователя по id из модели
    $userBean = R::load('users', $userId);
    
    // Обнволяем корзину 
    $userBean->cart = json_encode($cartItems);
    R::store($userBean);
  }

  public function removeUser () {

  }
 
} 