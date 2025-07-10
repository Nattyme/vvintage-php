<?php
declare(strict_types=1);

namespace Vvintage\Services\Security;
use Vvintage\Models\User\User;
use Vvintage\Repositories\UserRepository;

use RedBeanPHP\R;
// use Vvintage\Config\Config;

final class PasswordSetNewService 
{
  private UserRepository $userRepository;

  public function __construct (UserRepository $userRepository) {
    $this->userRepository = $userRepository;
  }

  public function findUserByEmail(string $userEmail): User
  {
    $userModel = $this->userRepository->findUserByEmail($userEmail);

    return $userModel;
  }

}
