<?php

declare(strict_types=1);

namespace Vvintage\Controllers\Orders;

use Vvintage\Routing\Router;
use Vvintage\Routing\RouteData;

/** Интерфейсы */
use Vvintage\Models\User\UserInterface;
use Vvintage\Store\UserItemsList\ItemsListStoreInterface;

/** Сервисы */
use Vvintage\Services\Order\OrderService;
use Vvintage\Services\Cart\CartService;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Validation\NewOrderValidator;

/** Модели */
use Vvintage\Models\Cart\Cart;
use Vvintage\Models\Order\Order;
use Vvintage\Models\Settings\Settings;

/** Хранилище */

/** DTO */
use Vvintage\DTO\Order\OrderDTO;


require_once ROOT . './libs/functions.php';

final class OrdersController
{
    private OrderService $orderService;
    private CartService $cartService;
    private UserInterface $userModel;
    private Cart $cartModel;
    private array $cart;
    private ItemsListStoreInterface $cartStore;
    private NewOrderValidator $validator;
    private FlashMessage $notes;
  

    public function __construct(
      OrderService $orderService, 
      CartService $cartService, 
      UserInterface $userModel,
      Cart $cartModel,
      array $cart,
      ItemsListStoreInterface $cartStore,
      NewOrderValidator $validator,
      FlashMessage $notes
    )
    {
      $this->cartService = $cartService;
      $this->userModel = $userModel;
      $this->cartModel = $cartModel;
      $this->cart = $cart;
      $this->cartStore = $cartStore;
      $this->validator = $validator;
      $this->notes = $notes;
    }

    public function index(RouteData $routeData): void
    {
      if ( !empty($this->cart) ) {
        // Получаем продукты
        $products = $this->cartService->getListItems();
        $totalPrice = $this->cartService->getCartTotalPrice($products, $this->cartModel);
       
      } else {
        $products = array();
      }

      if (!isset($_POST['submit'])) {
        // Показываем страницу
        $this->renderForm($routeData, $products, $this->cartModel, $totalPrice);
        return;
      }

      if (isset($_POST['submit'])) {
        if (!$this->validator->validate($_POST)) {
          // Показываем страницу
          $this->renderForm($routeData, $products, $this->cartModel, $totalPrice);
          return;
        }

        if($this->userModel instanceof Guest) {
          header('Location: ' . HOST . 'login');
          exit();
        }

        // Вызываем DTO
        $orderDTO = new OrderDTO($_POST);
        // $orderDTO->validate();
        
        $order = $this->orderService->create($orderDTO);
        
        if ($order !== null) {
            // Очищаем корзину
            $this->cart->clear();

            header('Location: ' . HOST . 'ordercreated?id=' . $order->export()['id']);
            exit();
        } else {
            // сообщение об ошибке
            $this->notes->pushError("Произошла ошибка при создании заказа.");
            $this->renderForm($routeData, $products, $this->cartModel, $totalPrice);
            return;
        }
      }
    }

    private function edit(Order $order, array $postData)
    {
      $this->orderService->edit($order, $postData);
    }

    private function created($routeData) 
    {
      $pageTitle = "Заказ оформлен!";

       // Хлебные крошки
      $breadcrumbs = [
        ['title' => $pageTitle, 'url' => '#'],
      ];
      // $lang = get('lang', ['ru', 'en', 'fr'], 'ru');

      // Получаем GET['id] 
      $new_order_id = get('id', int);

      include ROOT . "templates/_page-parts/_head.tpl";
      include ROOT . "templates/_parts/_header.tpl";
      include ROOT . "templates/orders/created.tpl";
      include ROOT . "templates/_parts/_footer.tpl";
      include ROOT . "templates/_page-parts/_foot.tpl";
    }

    private function renderForm ($routeData, array $products, Cart $cartModel, int $totalPrice): void 
    {  
      /**
        * Проверяем вход пользователя в профиль
        * @var bool
      */
      $settings = Settings::all(); // Получаем массив всех настроек
      
      $pageTitle = "Оформление нового заказа";

      // Хлебные крошки
      $breadcrumbs = [
        ['title' => $pageTitle, 'url' => '#'],
      ];

      // Подключение шаблонов страницы
      include ROOT . "templates/_page-parts/_head.tpl";
      include ROOT . "views/_parts/_header.tpl";
      include ROOT . "views/orders/new.tpl";
      include ROOT . "views/_parts/_footer.tpl";
      include ROOT . "views/_page-parts/_foot.tpl";
    }
}
