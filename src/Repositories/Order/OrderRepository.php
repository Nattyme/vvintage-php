<?php

declare(strict_types=1);

namespace Vvintage\Repositories;


use RedBeanPHP\R; // Подключаем readbean
use RedBeanPHP\OODBBean; // для обозначения типа даннных

/** Контракты */
use Vvintage\Contracts\Order\OrderRepositoryInterface;

/** Абстрактный репозиторий */
use Vvintage\Repositories\AbstractRepository;

use Vvintage\Repositories\Address\AddressRepository;

/** Модели */
use Vvintage\Models\User\User;
use Vvintage\Models\Order\Order;



final class OrderRepository extends AbstractRepository implements OrderRepositoryInterface
{
    private AddressRepository $addressRepository;

    public function __construct()
    {
        $this->addressRepository = new AddressRepository();
    }

    private function fillOrderBean(OODBBean $bean, Order $order)
    {
        $bean->name = $order->getName();
        $bean->surname = $order->getSurname();
        $bean->email = $order->getEmail();
        $bean->phone = $order->getPhone();
        $bean->address = $order->getAddress();
        $bean->datetime = $order->getDateTime();
        $bean->status = $order->getStatus();
        $bean->paid = $order->getPaid();
        $bean->cart = json_encode($order->getCart());
        $bean->price = $order->getPrice();
    }


    /**
     * Метод ищет заказ по id
     * @param int $id
     * @return OODBBean[]
     */
    public function findOrderById(int $id): ?Order
    {
        $bean = $this->loadBean('orders', $id);

        if ($bean->id === 0) {
            return null;
        }

        return Order::fromBean($bean);
    }

    /**
     * Метод ищет все заказы по id пользователя
     * @param int $id
     * @return @return OODBBean[]
     */
    public function findOrdersByUserId(int $id): array
    {
        $orders = [];
        $beans = $this->findAll('orders', 'user_id = ?', [$id]);

        foreach($beans as $bean) {
          $orders[] = Order::fromBean($bean);
        }

        return $orders;
    }

    /**
     * Метод создает новый заказ
     *
     * @return User|null
    */
    public function createOrder( Order $order, User $user): ?Order
    {
        $bean = $this->createBean('orders');

        // Записываем параметры в bean
        $this->fillOrderBean($bean, $order);

        // Привязываем заказ к пользователю
        $userBean = $this->loadBean('users', $user->getId());
        $bean->user = $userBean;

        // Сохраняем в БД
        $id = $this->saveBean($bean);

        if (!is_int($id) || $id === 0) {
            return null;
        }

        return Order::fromBean($bean);
    }


    /**
     * Метод редактирует пользователя
     * @param User $userModel, array $newUserData
     * @return Order|null
     */
    public function editOrder(int $id, array $order, User $user): ?Order
    {
        $bean = $this->loadBean('orders', $id);

        if ($bean->id !== 0) {
            // Записываем параметры в bean и сохраняем в БД
            $this->fillOrderBean($bean, $order);

            $id = $this->saveBean($bean);

            if (!is_int($id) || $id === 0) {
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
        $id = $order->getId();
        $user_id = $userModel->getId();

        $bean = $this->loadBean('orders', $id);

        if ($bean->id !== 0 && ($user_id === $bean->user_id || $userModel->getRole() === 'admin')) {
            $this->deleteBean($bean);
        }

    }

    public static function countNewOrders(): int
    {
        $beans = $this->findAll('orders', 'status = ?', ['new']);

        foreach($beans as $bean) {
          $orders[] = Order::fromBean($bean);
        }

        return count($beans);
    }

}
