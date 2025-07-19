<?php

declare(strict_types=1);

namespace Vvintage\Repositories;

use RedBeanPHP\R; // Подключаем readbean
use RedBeanPHP\OODBBean; // для обозначения типа даннных
use Vvintage\Models\User\User;
use Vvintage\Models\Cart\Cart;
use Vvintage\Repositories\AddressRepository;

final class OrderRepository
{
    private AddressRepository $addressRepository;

    public function __construct()
    {
      // $this->cart = $cart;
      $this->addressRepository = new AddressRepository();
    }

    /**
     * Метод ищет заказ по id
     * @param int $id
     * @return Order|null
     */
    public function findOrderById(int $id): ?Order
    {
        $bean = R::load('orders', $id);

        if ($bean->id === 0) {
            return null;
        }

        return new Order($bean);
    }

    /**
     * Метод ищет все заказы по id пользователя 
     * @param int id
     * @return OODBBean
     */
    public function findOrdersByUserId(int $id): array
    {
      $beans = R::findAll('orders', 'user_id = ?', [$id]);

      return $beans ?? [];
    }


    /**
     * Метод возвращает все заказы
     * 
     * @return array
     */
    public function findAll(): array
    {
      return R::findAll( 'orders' );
    }



    /**
     * Метод создает новый заказ 
     * 
     * @return User|null
    */
    public function createOrder(User $user, array $postData): ?Order
    {
        $bean = R::dispense('orders');
        $bean->name = htmlentities(trim($postData['name']));
        $bean->surname = htmlentities(trim($postData['surname']));
        $bean->email = filter_var(htmlentities(trim($postData['email'])), FILTER_VALIDATE_EMAIL);
        $bean->phone = trim($postData['phone']);
        $bean->address = htmlentities(trim($postData['address']));
        $bean->timestamp = time();
        $bean->status = 'new';
        $bean->paid = false;

        $bean->cart = json_encode($user->getCart());

      // Проверить в таблице адресов если адреса нет добавить новый? или не нужно?
        // $addressModel = $this->addressRepository->createAddress(); // создаем новый адрес
        // $addressId = $addressModel->getId();

      // if (!is_int($addressId) || $addressId === 0) {
      //   return null;
      // }

      // $addressBean = R::load('address', $addressId);
      // $bean->address = $addressBean;

      $orderId = R::store($bean);

      if (!is_int($orderId) || $orderId === 0) {
        return null;
      }

      return new Order ($bean);
    }


    /**
     * Метод редактирует пользователя 
     * @param User $userModel, array $newUserData
     * @return Order|null
     */
    public function editOrder(User $user, Order $order, array $postData): ?Order
    {
        $id = $order->getId();
        $bean = R::load('orders', $id);

        if($bean->id !== 0 && $user->getRole() === 'admin') {
          $bean = R::load('orders', $order->getId());
          $bean->name = htmlentities(trim($postData['name']));
          $bean->surname = htmlentities(trim($postData['surname']));
          $bean->email = filter_var(htmlentities(trim($postData['email'])), FILTER_VALIDATE_EMAIL);
          $bean->phone = trim($postData['phone']);
          $bean->address = htmlentities(trim($postData['address']));
          $bean->timestamp = time();
          $bean->status = 'new';
          $bean->paid = false;

          $bean->cart = json_encode($user->getCart());
          $orderId = R::store($bean);

          if (!is_int($orderId) || $orderId === 0) {
            return null;
          }

          return new Order ($bean);

        } else {
          return null;
        }


        return null;
      }



    /**
     * Метод удаления заказа 
     * 
     * @return void
    */
    public function removeOrder(Order $order, User $userModel): void
    {
      $order_id = $order->getId();
      $user_id = $userModel->getId();

      $bean = R::load('orders', $order_id);

      if ($bean->id !== 0 && ($user_id === $bean->user_id || $userModel->getRole() === 'admin')) {
        R::trash( $bean ); 
      }

    }



}
