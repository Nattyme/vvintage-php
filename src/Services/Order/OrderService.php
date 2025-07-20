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
    //       $dto = new OrderDTO($postData);

    // if (!$dto->isValid()) {
    //     $this->note->pushError('Пожалуйста, заполните все поля корректно');
    //     return;
    // }

    // $order = Order::fromDTO($dto);
    // $this->orderRepository->create($order, $this->user->getId());

    // $this->note->pushSuccess('Заказ успешно оформлен!');
      $order = $this->prepareDataForBean($postData);
      $this->orderRepository->create($order, $this->user->getId());
    }

    public function edit(Order $order, array $postData)
    {
      // Проверяем, что заказ редактирует админ
      if($this->user->getRole() !== 'admin') {
        $this->note->pushError('Нет прав на редатирование заказа');
        return;
      }

      // Подготавливаем данные из POST
      $order = $this->prepareDataForBean($postData);

      // Сохраняем заказ
      $result = $this->orderRepository->edit($order->getId(), $order);

      if (!$result) {
        $this->note->pushError('Ошибка при сохранении заказа.');
        return;
      }
      $this->note->pushSuccess('Заказ успешно изменён');
    }


    // private function prepareDataForBean(array $postData): ?Order
    // {

    //     $order['name'] = h(trim($_POST['name']));
    //     $order['surname'] = h(trim($_POST['surname']));
    //     $order['email'] = filter_var(h(trim($_POST['email'])), FILTER_VALIDATE_EMAIL);
    //     $order['phone'] = h(trim($_POST['phone']));
    //     $order['address'] = h(trim($_POST['address']));
    //     $order['timestamp'] = time();
    //     $order['status'] = 'new';
    //     $order['paid'] = false;
    //     $order['cart'] = json_encode($cart);


    //     return $order;
    // }


}
