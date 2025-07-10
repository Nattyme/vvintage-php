<?php
declare(strict_types=1);

namespace Vvintage\Services\User;
use Vvintage\Models\User\User;
use Vvintage\Repositories\UserRepository;

final class UserService
{
  private UserRepository $userRepository;

  public function __construct (UserRepository $userRepository) {
    $this->userRepository = $userRepository;
  }
  
// createNewUser
  public function createUser (array $postData):void
  {
   
    /**
     * @var User|null
    */
    $user = $this->userRepository->createUser($postData);
    $userId = $user->getId();

    if ( is_int($userId) ) {
      // Создаем адрес пользователи в таблицу адресов доставки и сохраняем Id адреса 
      $addressId = $this->userRepository->createAddress( $userId );

      // Обновляем пользователя, добавляя address_id
      $this->userRepository->updateUserAddressId( $userId, $addressId );
    }
  }
}