<?php

declare(strict_types=1);

namespace Vvintage\Controllers\Order;

use Vvintage\Routing\Router;
use Vvintage\Routing\RouteData;

/** Базовый контроллер страниц*/
use Vvintage\Controllers\Base\BaseController;

/** Интерфейсы */
use Vvintage\Models\User\UserInterface;
use Vvintage\Store\UserItemsList\ItemsListStoreInterface;

/** Сервисы */
use Vvintage\Services\Order\OrderService;
use Vvintage\Services\Cart\CartService;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Validation\NewOrderValidator;
use Vvintage\Services\Page\Breadcrumbs;

/** Модели */
use Vvintage\Models\User\User;
use Vvintage\Models\User\GuestUser;
use Vvintage\Models\Cart\Cart;
use Vvintage\Models\Order\Order;
use Vvintage\Models\Settings\Settings;

/** Хранилище */

/** DTO */
use Vvintage\DTO\Order\OrderDTO;


require_once ROOT . './libs/functions.php';

final class OrderController extends BaseController
{
    private OrderService $orderService;
    private CartService $cartService;
    private UserInterface $userModel;
    private Cart $cartModel;
    private array $cart;
    private ItemsListStoreInterface $cartStore;
    private NewOrderValidator $validator;
    private FlashMessage $notes;
    private Breadcrumbs $breadcrumbsService;
  

    public function __construct(
      OrderService $orderService, 
      CartService $cartService, 
      UserInterface $userModel,
      Cart $cartModel,
      array $cart,
      ItemsListStoreInterface $cartStore,
      NewOrderValidator $validator,
      FlashMessage $notes,
      Breadcrumbs $breadcrumbs
    )
    {
      parent::__construct(); // Важно!
      $this->orderService = $orderService;
      $this->cartService = $cartService;
      $this->userModel = $userModel;
      $this->cartModel = $cartModel;
      $this->cart = $cart;
      $this->cartStore = $cartStore;
      $this->validator = $validator;
      $this->notes = $notes;
      $this->breadcrumbsService = $breadcrumbs;
    }

    public function index(RouteData $routeData): void
    {
      
      if(empty($this->cart)) {
        header('Location: ' . HOST . 'cart');
        exit();
      }
    
      // Получаем продукты
      $products = $this->cartService->getListItems();
      $totalPrice = $this->cartService->getCartTotalPrice($products, $this->cartModel);
       

      if (!isRequestMethod('post') || !$this->validator->validate($_POST)) {
        // Показываем страницу
        $this->renderForm($routeData, $products, $this->cartModel, $totalPrice);
        return;
      } 
      
      if($this->userModel instanceof GuestUser) {
        header('Location: ' . HOST . 'login');
        exit();
      }


      // Вызываем DTO
      $orderDTO = new OrderDTO($_POST, $this->cart, $totalPrice, $this->userModel->getId());
      // $orderDTO->validate();

      $order = $this->orderService->create($orderDTO);

      if ($order !== null) {
          // Очищаем корзину
          $this->cartModel->clear();

          header('Location: ' . HOST . 'ordercreated?id=' . $order->export()['id']);
          exit();
      } 

      // сообщение об ошибке
      $this->notes->pushError("Произошла ошибка при создании заказа.");
      $this->renderForm($routeData, $products, $this->cartModel, $totalPrice);
    }

    private function edit(Order $order, array $postData)
    {
      $this->orderService->edit($order, $postData);
    }

    public function renderCreated($routeData) 
    {
      // Название страницы
      $pageTitle = 'Заказ оформлен!';

      // Хлебные крошки
      $breadcrumbs = $this->breadcrumbsService->generate($routeData, $pageTitle);

      
      // Получаем GET['id] 
      $new_order_id = get('id', 'int');

      // Если заказ не создан
      if (!$new_order_id || $new_order_id <= 0) {
        $this->notes->pushError('ID заказа не найден');
        header('Location: ' . HOST);
        exit();
      }

      // Подключение шаблонов страницы
      $this->renderLayout('orders/created', [
            'pageTitle' => $pageTitle,
            'routeData' => $routeData,
            'breadcrumbs' => $breadcrumbs
      ]);
    }

    private function renderForm ($routeData, array $products, Cart $cartModel, int $totalPrice): void 
    {  
      // Название страницы
      $pageTitle = 'Оформление нового заказа';

      // Хлебные крошки
      $breadcrumbs = $this->breadcrumbsService->generate($routeData, $pageTitle);

      // Подключение шаблонов страницы
      $this->renderLayout('orders/new', [
            'pageTitle' => $pageTitle,
            'cartModel' => $cartModel,
            'routeData' => $routeData,
            'products' => $products,
            'totalPrice' => $totalPrice,
            'breadcrumbs' => $breadcrumbs
      ]);
    }
}
