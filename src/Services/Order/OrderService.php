<?php

declare(strict_types=1);

namespace Vvintage\Services\Order;

use Vvintage\Models\Order\Order;
use Vvintage\Repositories\Order\OrderRepository;
use Vvintage\Services\Shared\AbstractUserItemsListService;
use Vvintage\Services\Base\BaseService;
use Vvintage\Services\Product\ProductService;
use Vvintage\Models\User\UserInterface;
 use Vvintage\Models\User\User;
  use Vvintage\Models\User\GuestUser;

/** DTO */
use Vvintage\DTO\Order\OrderDTO;


// extends AbstractUserItemsListService
class OrderService extends BaseService
{
    protected OrderRepository $orderRepository;
    private ProductService $productService;

    
    private array $status = [
      'new'   => 'Создан',
      'confirmed'   => 'Подтверждён',
      'pending' => 'Ожидает оплаты',
      'paid' => 'Оплачен',
      'in_progress' => 'В работе',
      'shipped' => 'Отправлен',
      'delivered' => 'Ожидает в месте вручения',
      'completed' => 'Завершён',
      'canceled' => 'Отменён'
    ];

    public function __construct()
    {
      parent::__construct();
      $this->orderRepository = new OrderRepository();
      $this->productService = new ProductService();
    }

    public function getStatusData(): array 
    {
      return $this->status;
    }

    public function getOrderTotalPrice($products, $cartModel)
    {
        return !empty($products) ? $cartModel->getTotalPrice($products) : 0;
    }

    public function create(OrderDTO $dto, $userModel)
    {
 
      // Создаем объект заказа через метод 
      $order = Order::fromDTO($dto);
         
      $order->setCart( $this->prepareCartData($order->getCart()));
   
      // Сохраняем заказ в БД
      return $this->orderRepository->createOrder($order, $userModel);
    }

    private function prepareCartData(array $cart): array
    {
        $result = [];

        // 1. Получаем продукты по id-шникам
        $productData = $this->productService->getProductsByIds($cart) ?? [];

        // 2. Преобразуем корзину в массив с нужной информацией
        foreach ($cart as $productId => $amount) {
            if (!isset($productData[$productId])) {
                continue; // если товар не найден, пропускаем
            }

            $product = $productData[$productId];

            $result[] = [
                'id'     => (int) $product->id,
                'title'  => $product->title,
                'price'  => (float) $product->price,
                'amount' => (int) $amount,
            ];
        }

        return $result;
    }

    public function getOrderById(int $id): ?Order
    {
      return $this->orderRepository->getOrderById($id);
    }

}
