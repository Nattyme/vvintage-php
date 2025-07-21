<?php

declare(strict_types=1);

namespace Vvintage\Repositories;

use RedBeanPHP\R; // Подключаем readbean
use RedBeanPHP\OODBBean; // для обозначения типа даннных
use Vvintage\Models\User\User;
use Vvintage\Models\Order\Order;
use Vvintage\Repositories\AddressRepository;

final class OrderRepository
{
    private AddressRepository $addressRepository;

    public function __construct()
    {
        // $this->cart = $cart;
        $this->addressRepository = new AddressRepository();
    }

    private function fillOrderBean(OODBBean $bean, Order $order, User $user)
    {
        $bean->name = $order->getName();
        $bean->surname = $order->getSurname();
        $bean->email = $order->getEmail();
        $bean->phone = $order->getPhone();
        $bean->address = $order->getAddress();
        $bean->timestamp = $order->getTimestamp();
        $bean->status = $order->getStatus();
        $bean->paid = $order->getPaid();
        $bean->cart = json_encode($order->getCart());
    }

    private function loadBean(int $id)
    {
        return  R::load('orders', $id);
    }

    private function saveBean(OODBBean $bean)
    {
        return R::store($bean);
    }



    /**
     * Метод ищет заказ по id
     * @param int $id
     * @return OODBBean[]
     */
    public function findOrderById(int $id): ?Order
    {
        $bean = $this->loadBean($id);

        if ($bean->id === 0) {
            return null;
        }

        return new Order($bean);
    }

    /**
     * Метод ищет все заказы по id пользователя
     * @param int $id
     * @return @return OODBBean[]
     */
    public function findOrdersByUserId(int $id): array
    {
        $beans = R::findAll('orders', 'user_id = ?', [$id]);

        return is_array($beans) ? $beans : [];
    }


    /**
     * Метод возвращает все заказы
     *
     * @return array
     */
    public function findAll(): array
    {
        return R::findAll('orders');
    }


    /**
     * Метод создает новый заказ
     *
     * @return User|null
    */
    public function create( Order $order, User $user): ?Order
    {
        $bean = R::dispense('orders');

        // Записываем параметры в bean
        $this->fillOrderBean($bean, $order, $user);

        // Привязываем заказ к пользователю
        $userBean = R::load('users', $user->getId());
        $bean->user = $userBean;

        // Сохраняем в БД
        $orderId = $this->saveBean($bean);

        if (!is_int($orderId) || $orderId === 0) {
            return null;
        }

        return Order::fromBean($bean);
    }


    /**
     * Метод редактирует пользователя
     * @param User $userModel, array $newUserData
     * @return Order|null
     */
    public function edit(int $orderId, array $order, User $user): ?Order
    {
        $bean = $this->loadBean($orderId);

        if ($bean->id !== 0) {
            // Записываем параметры в bean и сохраняем в БД
            $this->fillOrderBean($bean, $order, $user);
            $orderId = $this->saveBean($bean);

            if (!is_int($orderId) || $orderId === 0) {
                return null;
            }

            return new Order($bean);

        } else {
            return null;
        }
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

        $bean = $this->loadBean($order_id);

        if ($bean->id !== 0 && ($user_id === $bean->user_id || $userModel->getRole() === 'admin')) {
            R::trash($bean);
        }

    }



}
