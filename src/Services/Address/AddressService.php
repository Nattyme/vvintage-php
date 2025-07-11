<?php
declare(strict_types=1);

namespace Vvintage\Services\User;

use Vvintage\Models\Address\Address;
use Vvintage\Repositories\AddressRepository;

final class AddressService
{
  private AddressRepository $addressRepository;

  public function __construct (AddressRepository $addressRepository) {
    $this->addressRepository = $addressRepository;
  }
  
  public function createAddress ($user_id, array $postData): ?Adress
  {
    return $this->addressRepository->createAddress($userId, $postData);
  }
}