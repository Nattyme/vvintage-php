<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Cart;

use RedBeanPHP\R; // Подключаем readbean
use Vvintage\Routing\Router;
use Vvintage\Routing\RouteData;
use Vvintage\Repositories\ProductRepository;
use Vvintage\Models\Settings\Settings;
use Vvintage\Models\Shop\Catalog;
use Vvintage\Models\Cart\Cart;
use Vvintage\Repositories\CartRepository;
use Vvintage\Services\CartService;
use Vvintage\Models\Auth\Auth;
use Vvintage\Models\User\User;
use Vvintage\Repositories\UserRepository;

require_once ROOT . './libs/functions.php';

final class CartController
{
  private CartService $cartService;

  public function __construct(CartService $cartService)
  {
    $this->cartService = $cartService;
  }

  public static function index(RouteData $data): void
  {
    // Проверяем вход пользователя в профиль
    $isLoggedIn = Auth::isLoggedIn();
    $settings = Settings::all(); // Получаем массив всех настроек
    // $cartService = new CartService(new CartRepository());
 
    if ($isLoggedIn) 
    {
      print_r('Пользователь зашел в профиль');
   
      // dd($_COOKIE);
      // Получаем информацию по продуктам из списка корзины 
      $cartController = new CartController(new CartService(new CartRepository));
      $loggedUser = $isLoggedIn ? Auth::getLoggedInUser() : null;
      $cart = $cartController->loadCart($isLoggedIn, $loggedUser);
      $cartItems = $cart->getItems();
      
      if ( !empty($cartItems) ) {
        $products = ProductRepository::findByIds($cart->getItems());
        $totalPrice = $cart->getTotalPrice($products);
      }
   
    }

    if (!$isLoggedIn) {
      print_r('Пользователь не зашел в профиль');
      $cartController = new CartController(new CartService(new CartRepository));

      // Загружаем корзину
      $cart = $cartController->loadCart($isLoggedIn);
      $cartItems = $cart->getItems();

      if( !empty($cartItems) ) {
        // Получаем товары по Ids корзины и считаем total
        $products = ProductRepository::findByIds($cart->getItems());
        $totalPrice = $cart->getTotalPrice($products);
      }

    }
    
    $pageTitle = "Корзина товаров";

    // Хлебные крошки
    $breadcrumbs = [
      ['title' => $pageTitle, 'url' => '#'],
    ];

    // Подключение шаблонов страницы
    include ROOT . "views/_page-parts/_head.tpl";
    include ROOT . "views/_parts/_header.tpl";
    include ROOT . "views/cart/cart.tpl";
    include ROOT . "views/_parts/_footer.tpl";
    include ROOT . "views/_page-parts/_foot.tpl";
  }

  public function loadCart(bool $isLoggedIn, User $user = null): Cart
  {
    $cartObj = new Cart();
    $cartData = $cartObj->loadCart($isLoggedIn, $user);
    $_SESSION['cart'] = $cartData;

    return new Cart($cartData);
  }

  public static function addItem($productId, $data)
  {
    $isLoggedIn = isLoggedIn();
    $user = $isLoggedIn  ? getLoggedInUser() : null; // получить объект User

    $cartService = new CartService(new CartRepository);
    $cartService->addItem((int) $productId, $isLoggedIn, $user);

    // Переадресация обратно на страницу товара (или корзины)
    header('Location: ' . HOST . 'shop/' . $productId);
    exit();
  }

}