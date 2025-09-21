<?php
declare(strict_types=1);

namespace Vvintage\Services\Admin\Order;

use Vvintage\Services\Messages\FlashMessage;

/** Репозитории */
use Vvintage\Repositories\Order\OrderRepository;
use Vvintage\Repositories\Product\ProductRepository;
use Vvintage\Services\Order\OrderService;

// use Vvintage\Repositories\MessageRepository;


final class AdminOrderService extends OrderService
{
  private array $actions = [
      'new'         => 'Создать',
      'confirmed'   => 'Подтвердить',
      'pending'     => 'Ожидать оплату',
      'paid'        => 'Оплатить',
      'in_progress' => 'Начать обработку',
      'shipped'     => 'Отправить',
      'delivered'   => 'Отметить доставленным в пункт выдачи',
      'completed'   => 'Завершить',
      'canceled'    => 'Отменить'
  ];


  public function __construct()
  {
    parent::__construct();
  }
  

  public function getActions()
  {
    return $this->actions;
  }

  public function handleStatusAction(array $data): void 
  {
      if ( 
        isset($data['action-submit']) && 
        (isset($data['action']) && !empty($data['action'])) &&
        (isset($data['orders']) && !empty($data['orders'])) ) {
        $action = $data['action'];

        foreach ($data['orders'] as $key=> $orderId) {
          $this->applyAction((int) $orderId, $action);
        }

      }

  }

  private function applyAction(int $orderId, string $action): bool
  {
      switch ($action) {
          case 'new':
              return $this->hideProduct($orderId);
          case 'confirmed':
              return $this->publishProduct($orderId);
          case 'pending':
              return $this->publishProduct($orderId);
          case 'paid':
              return $this->publishProduct($orderId);
          case 'in_progress':
              return $this->publishProduct($orderId);
          case 'shipped':
              return $this->publishProduct($orderId);
          case 'delivered':
              return $this->publishProduct($orderId);
          case 'completed':
              return $this->publishProduct($orderId);
          case 'canceled':
              return $this->publishProduct($orderId);
          default:
              return false;

      }
  }



  public function getAllOrdersActions($pagination)
  {
    return $this->orderRepository->getAllOrders($pagination);
  }

  public function getAllOrdersCount()
  {
    return $this->orderRepository->getAllOrdersCount();
  }

  public function getAllOrders($pagination): array
  {
    return $this->orderRepository->getAllOrders($pagination);
  }

    // public function edit(Order $order, array $postData)
    // {
    //   // Проверяем, что заказ редактирует админ
    //   if($this->user->getRole() !== 'admin') {
    //     $this->note->pushError('Нет прав на редатирование заказа');
    //     return;
    //   }

    //   // Передаем данные из POST в DTO
    //   $dto = new OrderDTO($postData);
    //   if (!$dto->isValid()) {
    //       $this->note->pushError('Пожалуйста, заполните все поляю');
    //       return;
    //   }

    //   // Создаем объект заказа через метод 
    //   $order = Order::fromDTO($dto);

    //   // Сохраняем заказ в БД
    //   $result = $this->orderRepository->edit($order->getId(), $order, $this->user);

    //   if (!$result) {
    //     $this->note->pushError('Ошибка при сохранении заказа.');
    //     return;
    //   }
    //   $this->note->pushSuccess('Заказ успешно изменён');
    // }

}
