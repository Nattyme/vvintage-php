<?php
declare(strict_types=1);

namespace Vvintage\Services\User;

use Vvintage\Models\User\User;
use Vvintage\Models\Address\Address;
use Vvintage\Repositories\UserRepository;
use Vvintage\Repositories\AddressRepository;
use Vvintage\Services\Address\AddressService;

final class UserService
{
  private UserRepository $userRepository;
  private AddressService $addressService;

  public function __construct (UserRepository $userRepository, AddressService $addressService) {
    $this->userRepository = $userRepository;
    $this->addressService = $addressService;
  }
  
// createNewUser
  public function createUser (array $postData): ?User
  {
   
    /**
     * @var User|null
    */
    $user = $this->userRepository->createUser($postData);
    $userId = $user->getId();

    if ( is_int($userId) ) {
      // Создаем адрес пользователи в таблицу адресов доставки и сохраняем Id адреса 
      $addressModel = $this->addressService->createAddress( $userId, $postData);
      dd($addressModel);
      $addressId = $addressModel->getId();

      // Обновляем пользователя, добавляя address_id
      $this->userRepository->updateUserAddressId( $userId, $addressId );
    }

    return $user;
  }
}