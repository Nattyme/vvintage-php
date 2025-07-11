<?php

declare(strict_types=1);

namespace Vvintage\Repositories;

use RedBeanPHP\R; // Подключаем readbean
use RedBeanPHP\OODBBean; // для обозначения типа даннных
use Vvintage\Models\Address\Address;

final class AddressRepository
{
    /**
     * Метод ищет адрес по id
     * @param int $id
     * @return Address|null
     */
    public function findAddressById(int $id): ?Address
    {
        $bean = R::load('address', $id);

        if ($bean->id === 0) {
            return null;
        }

        return new Address($bean);
    }

    /**
     * Метод ищет пользователя по email
     * @param string $email
     * @return OODBBean
     */
    public function findAddressByUserId(int $user_id): ?Address
    {
      $bean = R::findOne('address', 'user_id = ?', [$user_id]);

      if (!$bean) {
          return null;
      }

      return new Address($bean);
    }


    /**
     * Метод возвращает все адреса
     * 
     * @return array
     */
    public function findAll(): array
    {
      return R::findAll( 'address' );
    }



    /**
     * Метод создает нового пользователя 
     * 
     * @return Address|null
    */
    public function createAddress(int $user_id, array $postData): ?Address
    {
      $userBean = R::load('users', $user_id);
      $bean = R::dispense( 'address' );

      $bean->user_id = $userBean->id;
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
      $userId = R::store($bean);
   
      return new Address ($bean);
    }

    /**
     * Метод редактирует пользователя 
     * @param Address $addressrModel array $postData
     * @return Address|null
     */
    public function editAddress(Address $addressModel, array $postData): ?Address
    {
      $id = $addressModel->getId();
      $bean = R::load('address', $id);

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
        $addressId = R::store($bean);
    
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
      $bean = R::load('address', $id);

      if ($bean->id !== 0) {
        R::trash( $bean ); 
      }

    }


}
