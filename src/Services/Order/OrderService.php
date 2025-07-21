<?php

declare(strict_types=1);

namespace Vvintage\Services\Order;

use RedBeanPHP\R;
use Vvintage\Models\Orders\Order;
use Vvintage\Repositories\OrderRepository;
use Vvintage\Models\User\User;
// use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Shared\AbstractUserItemsListService;

class OrderService extends AbstractUserItemsListService
{
    public function __construct(OrderRepository $orderRepository, User $user, FlashMessages $note)
    {
      $this->orderRepository=$orderRepository;
      $this->user=$user;
      $this->note=$note;
    }

    public function getOrderTotalPrice($products, $cartModel)
    {
        return !empty($products) ? $cartModel->getTotalPrice($products) : 0;
    }

    public function create(array $postData)
    {
      // Передаем данные из POST в DTO
      $dto = new OrderDTO($postData);
      if (!$dto->isValid()) {
          $this->note->pushError('Пожалуйста, заполните все поляю');
          return;
      }

      // Создаем объект заказа через метод 
      $order = Order::fromDTO($dto);

      // Сохраняем заказ в БД
      $this->orderRepository->create($order, $this->user->getId());
    }

    public function edit(Order $order, array $postData)
    {
      // Проверяем, что заказ редактирует админ
      if($this->user->getRole() !== 'admin') {
        $this->note->pushError('Нет прав на редатирование заказа');
        return;
      }

      // Передаем данные из POST в DTO
      $dto = new OrderDTO($postData);
      if (!$dto->isValid()) {
          $this->note->pushError('Пожалуйста, заполните все поляю');
          return;
      }

      // Создаем объект заказа через метод 
      $order = Order::fromDTO($dto);

      // Сохраняем заказ в БД
      $result = $this->orderRepository->edit($order->getId(), $order);

      if (!$result) {
        $this->note->pushError('Ошибка при сохранении заказа.');
        return;
      }
      $this->note->pushSuccess('Заказ успешно изменён');
    }


}
