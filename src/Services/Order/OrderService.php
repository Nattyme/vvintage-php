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
    public function __construct(OrderRepository $orderRepository, User $user)
    {
      $this->orderRepository=$orderRepository;
      $this->user=$user;
    }

    public function getOrderTotalPrice($products, $cartModel)
    {
        return !empty($products) ? $cartModel->getTotalPrice($products) : 0;
    }

    public function createNewOrder(array $postData)
    {
      $order = $this->prepareDataForBean($postData);
      $this->orderRepository->create($order, $this->user->getId());
    }

    private function setModel(){

    }

    private function prepareDataForBean(array $postData): ?Order
    {

        $order['name'] = h(trim($_POST['name']));
        $order['surname'] = h(trim($_POST['surname']));
        $order['email'] = filter_var(h(trim($_POST['email'])), FILTER_VALIDATE_EMAIL);
        $order['phone'] = h(trim($_POST['phone']));
        $order['address'] = h(trim($_POST['address']));
        $order['timestamp'] = time();
        $order['status'] = 'new';
        $order['paid'] = false;
        $order['cart'] = json_encode($cart);


        return $order;
    }


}
