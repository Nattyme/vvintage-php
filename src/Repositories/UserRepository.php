<?php
declare(strict_types=1);

namespace Vvintage\Repositories;

use RedBeanPHP\R; // Подключаем readbean
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

  public function findByEmail (): ?User {
    $bean = R::findOne('users', 'email = ?', array($_POST['email']));
    return new User($bean);
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