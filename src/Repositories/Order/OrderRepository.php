<?php

declare(strict_types=1);

namespace Vvintage\Repositories\Order;


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

use Vvintage\Public\DTO\Order\OrderDTO;



final class OrderRepository extends AbstractRepository implements OrderRepositoryInterface
{
    private const TABLE = 'orders';
    private AddressRepository $addressRepository;

    public function __construct()
    {
        $this->addressRepository = new AddressRepository();
    }

    private function fillOrderBean(OODBBean $bean, Order $order)
    {
  
        $bean->user_id = $order->getUserId();
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
        $bean->tracking_number = $order->getTrackingNumber();
        $bean->canceled_reason = $order->getCanceledReason();
        $bean->comment = $order->getComment();
        $bean->payment_type = $order->getPaymentType();
    }

    
    private function mapBeanToOrder(OODBBean $bean): Order
    {
    
        // $translations = $this->loadTranslations((int) $bean->id);

        // Получаем AddressDTO
        // $addressDTO = null;
        // if (!empty($bean->address_id)) {
        //     $addressDTO = $this->addressRepository->getAddressDTOById((int)$bean->address_id);
        // }
    
        $dto = OrderDTO::fromDatabase([
            'id' => (int) $bean->id,
            'name' => (string) $bean->name,
            'surname' => (string) $bean->surname,
            'email' => (string) $bean->email,
            'phone' => (string) $bean->phone,
            'address' => (string) $bean->address,
            'datetime' => (string) $bean->datetime,
            'status' => (string) $bean->status,
            'paid' => (string) $bean->paid,
            'cart' => (string) $bean->cart,
            'price' => (int) $bean->price,
            'tracking_number' => (string) $bean->tracking_number,
            'canceled_reason' => (string) $bean->canceled_reason,
            'comment' => (string) $bean->comment,
            'payment_type' => (string) $bean->payment_type,
            'user_id' => (int) $bean->user_id
        ]);

        return Order::fromDTO($dto);
    }



    /**
     * Метод ищет заказ по id
     * @param int $id
     * @return OODBBean[]
     */
    public function getOrderById(int $id): ?Order
    {
        $bean = $this->loadBean(self::TABLE, $id);

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
    public function getOrdersByUserId(int $id): array
    {
        $orders = [];
        $beans = $this->findAll(table: self::TABLE, conditions: ['user_id = ?'], params: [$id]);

        foreach($beans as $bean) {
          $orders[] = Order::fromBean($bean);
        }

        return $orders;
    }

    public function getAllOrders(): array
    {
        $beans = $this->findAll(table: self::TABLE);

        if (empty($beans)) {
          return [];
        }

        return array_map([$this, 'mapBeanToOrder'], $beans);
    }


    /**
     * Метод создает новый заказ
     *
     * @return User|null
    */
    public function createOrder( Order $order, User $user): ?Order
    {
        $bean = $this->createBean(self::TABLE);

        // Записываем параметры в bean
        $this->fillOrderBean($bean, $order);


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
        $bean = $this->loadBean(self::TABLE, $id);

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

        $bean = $this->loadBean(self::TABLE, $id);

        if ($bean->id !== 0 && ($user_id === $bean->user_id || $userModel->getRole() === self::ROLE_ADMIN)) {
            $this->deleteBean($bean);
        }

    }

    public function getAllOrdersCount (?string $sql = null, array $params = []): int
    {
      return $this->countAll(self::TABLE, $sql, $params);
    }

}
