<?php
declare(strict_types=1);

namespace Vvintage\Services\Admin;
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
      'in_progress' => 'Начать работу',
      'shipped'     => 'Отправить',
      'delivered'   => 'Доставить в пункт выдачи',
      'completed'   => 'Завершить',
      'canceled'    => 'Отменить'
  ];


  public function __construct(FlashMessage $note)
  {
    parent::__construct($note);
  }

  public function getActions()
  {
    return $this->actions;
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
