<?php

declare(strict_types=1);

namespace Vvintage\Repositories\Address;

use RedBeanPHP\R; // Подключаем readbean
use RedBeanPHP\OODBBean; // для обозначения типа даннных

/** Контракты */
use Vvintage\Contracts\Address\AddressRepositoryInterface;

/** Абстрактный репозиторий */
use Vvintage\Repositories\AbstractRepository;

use Vvintage\Models\Address\Address;
use Vvintage\DTO\Address\AddressDTO;
use Vvintage\DTO\Address\AddressOutputDTO;


final class AddressRepository extends AbstractRepository implements AddressRepositoryInterface
{   
    private const TABLE_ADDRESSES = 'address';

    private function mapBeanToAddress(OODBBean $bean): Address
    {
        $dto = new AddressOutputDTO([
            'id' => (int) $bean->id ?? 0,
            'name' => (string) $bean->name ?? '',
            'surname' => (string) $bean->surname ?? '',
            'fathername' => (string) $bean->fathername ?? '',
            'phone' => (string) $bean->phone ?? '',

            'country' => (string) $bean->country ?? '',
            'city' => (string) $bean->v ?? '',
            'area' => (string) $bean->area ?? '',

            'street' => (string) $bean->street ?? '',
            'building' => (string) $bean->building ?? '',
            'flat' => (string) $bean->flat ?? '',
            'post_index' => (string) $bean->post_index ?? '',

        ]);

        return Address::fromDTO($dto);
    }

    /**
     * Метод ищет адрес по id
     * @param int $id
     * @return Address|null
     */
    public function getAddressById(int $id): ?Address
    {
        $bean = $this->loadBean(self::TABLE_ADDRESSES, $id);

        if ($bean->id === 0) {
            return null;
        }

        return $this->getAddressDTOById($bean);
    }

    /**
     * Метод создает нового пользователя 
     * 
     * @return Address|null
    */
    public function createAddress(): ?Address
    {
      $bean = $this->createBean( self::TABLE_ADDRESSES );

      $bean->name = null;
      $bean->surname = null;
      $bean->fathername = null;
      $bean->country = null;
      $bean->area = null;
      $bean->city = null;
      $bean->street = null;
      $bean->building = null;
      $bean->flat = null;
      $bean->post_index = null;
      $bean->phone = null;
      

      // Сохраняем 
      $id = $this->saveBean($bean);

      if ( !is_int(  $id  )) {
        return null;
      }

      return new Address($bean);
  
    }

    /**
     * Метод редактирует пользователя 
     * @param Address $addressrModel array $postData
     * @return Address|null
     */
    public function editAddress(Address $addressModel, array $postData): ?Address
    {
      $id = $addressModel->getId();
      $bean = $this->loadBean(self::TABLE_ADDRESSES, $id);

      if ($bean->id !== 0) {
        $bean->name = $postData['name'] ?? '';
        $bean->surname = $postData['surname'] ?? '';
        $bean->fathername = $postData['fathername'] ?? '';
        $bean->country = $postData['country'] ?? '';
        $bean->area = $postData['area'] ?? '';
        $bean->city = $postData['city'] ?? '';
        $bean->street = $postData['street'] ?? '';
        $bean->building = $postData['building'] ?? '';
        $bean->flat = $postData['flat'] ?? '';
        $bean->post_index = $postData['post_index'] ?? '';
        $bean->phone = $postData['phone'] ?? '';

        // Сохраняем 
        $addressId = $this->saveBean($bean);
    
        return new Address ($bean) ?? null;       
      }

    }



    /**
     * Метод удаления адрес 
     * 
     * @return void
     * @param Address $addressModel
    */
    public function removeAddress(Address $addressModel): void
    {
      $id = $addressModel->getId();
      $bean = $this->loadBean(self::TABLE_ADDRESSES, $id);

      if ($bean->id !== 0) {
        $this->deleteBean( $bean ); 
      }

    }

    public function getAddressDTOById(int $addressId): ?AddressOutputDTO
    {
        $addressBean = $this->loadBean(self::TABLE_ADDRESSES, $addressId);

        if ($addressBean->id === 0) {
            return null;
        }

        return new AddressOutputDTO([
            'id' => $addressBean->id,
            'name' => $addressBean->name,
            'surname' => $addressBean->surname,
            'fathername' => $addressBean->fathername,
            'phone' => $addressBean->phone,

            'country' => $addressBean->country,
            'city' => $addressBean->city,
            'area' => $addressBean->area,

            'street' => $addressBean->street,
            'building' => $addressBean->building,
            'flat' => $addressBean->flat,
            'post_index' => $addressBean->post_index
        ]);
    }



}
