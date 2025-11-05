<?php 
declare(strict_types=1);

namespace Vvintage\Admin\Services\User;

use Vvintage\Public\Services\User\UserService;


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
