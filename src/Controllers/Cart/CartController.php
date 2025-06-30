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

  public function index(RouteData $data): void
  {
    // TO DO
    // После создания класса авторизации ДОБАВИТЬ ЗДЕСЬ ВЫЗОВ МЕТОДА ПРОВЕРКИ И ДЕЙСТВИЯ НА СЛУЧАЙ, ЕСЛИ ПОЛЬЗОВАТЕЛЬ НЕ ЗАЛОГИНЕН
    // Проверяем вход пользователя в профиль
    $isLoggedIn = isLoggedIn();
    $settings = Settings::all(); // Получаем массив всех настроек

    $cartData = [];
    if ( $isLoggedIn ) {
      $user = 
    }


    // $cartData = $cart->getCart($isLoggedIn);

    if (!empty($cartData)) 
    {
      // Получаем информацию по продуктам из списка корзины 
      $products = ProductRepository::findByIds($cartData);

      $cartTotalPrice = $cart->countTotalPrice($products);

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

  public function loadCart(array $loggedUser): array 
  {
    // Создаем объект корзины
    $cartModel = new Cart();

    // Создаем объект данных корзины
    $cartRepository = new CartRepository();
    
    // Создаем объект действий корзины
    $cartService = new CartService($cartRepository);
dd(  $cartService);

  }

  public static function addItem ($data): void
  {
    // Проверяем вход пользователя в профиль
    $isLoggedIn = isLoggedIn();
    Cart::addItem($isLoggedIn);
  }

  public static function removeItem($data): void
  {
    // Проверяем вход пользователя в профиль
    $isLoggedIn = isLoggedIn();
    Cart::removeItem($isLoggedIn);
  }

}