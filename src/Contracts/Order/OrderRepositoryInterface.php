<?php
declare(strict_types=1);

namespace Vvintage\Contracts\Order;

use Vvintage\Models\Order\Order;
use Vvintage\Models\User\User;

interface OrderRepositoryInterface
 {    
    /**
     * Метод ищет заказ по id
     * @param int $id
     * @return OODBBean[]
     */
    public function getOrderById(int $id): ?Order;

    /**
     * Метод ищет все заказы по id пользователя
     * @param int $id
     * @return @return OODBBean[]
     */
    public function getOrdersByUserId(int $id): array;

    /**
     * Метод создает новый заказ
     *
     * @return User|null
    */
    public function createOrder( Order $order, User $user): ?Order;


    /**
     * Метод редактирует пользователя
     * @param User $userModel, array $newUserData
     * @return Order|null
     */
    public function editOrder(int $id, array $order, User $user): ?Order;


    /**
     * Метод удаления заказа
     *
     * @return void
    */
    public function removeOrder(Order $order, User $userModel): void;

    public static function countNewOrders(): int;
}
