<?php 
declare(strict_types=1);

namespace Vvintage\admin\Services\User;

use Vvintage\Services\User\UserService;


final class AdminUserService extends UserService
{

    public function __construct()
    {
      parent::__construct();
    }

    public function getAllUsers ($pagination) :array 
    {
      return  $this->userRepository->getAllUsers($pagination);
    }

    public function getAllUsersCount (): int 
    {
      return  $this->userRepository->getAllUsersCount();
    }

}
