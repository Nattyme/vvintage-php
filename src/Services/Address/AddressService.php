<?php
declare(strict_types=1);

namespace Vvintage\Services\Address;

use Vvintage\Models\Address\Address;
use Vvintage\Repositories\Address\AddressRepository;

final class AddressService
{
  private AddressRepository $addressRepository;

  public function __construct () {
    $this->addressRepository = new AddressRepository();
  }
  
  public function createAddress (int $user_id, array $postData): ?Address
  {
    return $this->addressRepository->createAddress($user_id, $postData);
  }
}