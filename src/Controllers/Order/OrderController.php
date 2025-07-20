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
        if (!$this->$validator->validate($_POST)) {
          // Показываем страницу
          $this->renderForm($routeData, $products, $this->cartModel, $totalPrice);
          return;
        }
// Вызывать функцию сервиса котора готовит данные 
        // Валидируем данные для записи в БД
        $order = $this->orderService->createNewOrder($_POST);
       
// if ($order !== null) {
//     // redirect на страницу успешного оформления
//     header('Location: ' . HOST . 'ordercreated?id=' . $order->export()['id']);
//     exit();
// } else {
//     // сообщение об ошибке
//     $this->notes->add("Произошла ошибка при создании заказа.");
//     $this->renderForm($routeData, $products, $this->cartModel, $totalPrice);
//     return;
// }
        // // Сделать orderRepository Если массив ошибок пуст
        // $order = R::dispense('orders');
        // $order->name = h(trim($_POST['name']));
        // $order->surname = h(trim($_POST['surname']));
        // $order->email = filter_var(h(trim($_POST['email'])), FILTER_VALIDATE_EMAIL);
        // $order->phone = h(trim($_POST['phone']));
        // $order->address = h(trim($_POST['address']));
        // $order->timestamp = time();
        // $order->status = 'new';
        // $order->paid = false;

        // $order->cart = json_encode($cart);

        // Если пользователь вошел в профиль
        if ( isLoggedIn() ) { $order->user = $_SESSION['logged_user']; }

        $order_cart = array();
        $total_price = 0;

        foreach ($this->cart as $key => $value) {
          $current_item = array();

          $current_item['id'] = $key;
          $current_item['amount'] = $value;

          $product = R::load('products', $key); 
          $current_item['title'] = $product['title'];
          $current_item['price'] = $product['price'];
          
          $total_price = $total_price + ( $product['price'] * $value );

          $order_cart[] = $current_item;
        }

        $order->price = $total_price;
        $order->cart = json_encode($order_cart);
        // Сохраняем заказ
        $new_order_id = R::store($order);

        // Очищаем корзину
        if ( isLoggedIn() ) {
          $_SESSION['cart'] = array();
          $_SESSION['logged_user']->cart = '';

          R::store($_SESSION['logged_user']);

        } else {
          setcookie('cart', '', time() - 3600);
        }

        header('Location: ' . HOST . 'ordercreated?id=' . $new_order_id);
        exit();

      }
    }

    private function new()
    {

    }

    private function created($routeData) 
    {
      $pageTitle = "Заказ оформлен!";

       // Хлебные крошки
      $breadcrumbs = [
        ['title' => $pageTitle, 'url' => '#'],
      ];
      $new_order_id = $_GET['id'];

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
