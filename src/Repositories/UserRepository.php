<?php
declare(strict_types=1);

namespace Vvintage\Repositories;

use RedBeanPHP\R; // Подключаем readbean
use RedBeanPHP\OODBBean; // для обозначения типа даннных
use Vvintage\Models\User\User;

final class UserRepository 
{
  public function findById (int $id): ?User {
    $bean = R::load('users', $id);

    if ( !$bean || $bean->id === 0) {
      return null;
    }
    
    return new User($bean);
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

  public function saveUser () {

  }

  public function removeUser () {

  }
 
} 