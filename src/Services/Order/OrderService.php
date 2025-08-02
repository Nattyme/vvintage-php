<?php

declare(strict_types=1);

namespace Vvintage\Services\Order;

use RedBeanPHP\R;
use Vvintage\Models\Order\Order;
use Vvintage\Repositories\OrderRepository;
use Vvintage\Repositories\ProductRepository;
use Vvintage\Models\User\User;
// use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Shared\AbstractUserItemsListService;
use Vvintage\Services\Messages\FlashMessage;

/** DTO */
use Vvintage\DTO\Order\OrderDTO;


// extends AbstractUserItemsListService
class OrderService 
{
    private OrderRepository $orderRepository;
    private User $user;
    private ProductRepository $productRepository;
    private FlashMessage $note;

    public function __construct(OrderRepository $orderRepository, User $user, ProductRepository $productRepository, FlashMessage $note)
    {
      $this->orderRepository=$orderRepository;
      $this->user=$user;
      $this->productRepository=$productRepository;
      $this->note=$note;
    }

    public function getOrderTotalPrice($products, $cartModel)
    {
        return !empty($products) ? $cartModel->getTotalPrice($products) : 0;
    }

    public function create(OrderDTO $dto)
    {
      // Создаем объект заказа через метод 
      $order = Order::fromDTO($dto);
      $order->setCart( $this->prepareCartData($order->getCart()));
      
      // Сохраняем заказ в БД
      return $this->orderRepository->create($order, $this->user);
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
      $result = $this->orderRepository->edit($order->getId(), $order, $this->user);

      if (!$result) {
        $this->note->pushError('Ошибка при сохранении заказа.');
        return;
      }
      $this->note->pushSuccess('Заказ успешно изменён');
    }


    private function prepareCartData(array $cart): array
    {
        $result = [];

        // 1. Получаем продукты по id-шникам
        $productData = $this->productRepository->findProductsByIds($cart);

        // 2. Преобразуем корзину в массив с нужной информацией
        foreach ($cart as $productId => $amount) {
            if (!isset($productData[$productId])) {
                continue; // если товар не найден, пропускаем
            }

            $product = $productData[$productId];

            $result[] = [
                'id'     => (int) $product['id'],
                'title'  => $product['title'],
                'price'  => (float) $product['price'],
                'amount' => (int) $amount,
            ];
        }

        return $result;
    }

}
