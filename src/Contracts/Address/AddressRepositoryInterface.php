<?php
declare(strict_types=1);

namespace Vvintage\Contracts\Address;

use Vvintage\Models\Address\Address;
use Vvintage\DTO\Address\AddressDTO;


interface AddressRepositoryInterface
 { 
    /**
     * Метод ищет адрес по id
     * @param int $id
     * @return Address|null
     */
    public function getAddressById(int $id): ?Address;

    /**
     * Метод создает нового пользователя 
     * 
     * @return Address|null
    */
    public function createAddress(): ?Address;

    /**
     * Метод редактирует пользователя 
     * @param Address $addressrModel array $postData
     * @return Address|null
     */
    public function editAddress(Address $addressModel, array $postData): ?Address;

    /**
     * Метод удаления адрес 
     * 
     * @return void
     * @param Address $addressModel
    */
    public function removeAddress(Address $addressModel): void;
    public function getAddressDTOById(int $addressId): ?AddressDTO;
  }
