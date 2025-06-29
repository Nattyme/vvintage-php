<?php
declare(strict_types=1);

namespace Vvintage\Repositories;

use RedBeanPHP\R; // Подключаем readbean
use Vvintage\Models\User\User;

final class UserRepository 
{
  public function findById (int $id): ?User {
    $user = User::__construct(); 
  }

  public function findByEmail (): ?User {
    $userData = R::findOne('users', 'email = ?', array($_POST['email']));
    $user = User::__construct($userData);
    return $user;
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