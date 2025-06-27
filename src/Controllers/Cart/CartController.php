<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Cart;

use RedBeanPHP\R; // Подключаем readbean
use Vvintage\Routing\Router;
use Vvintage\Routing\RouteData;
use Vvintage\Models\Settings\Settings;
use Vvintage\Models\Cart\Cart;

require_once ROOT . './libs/functions.php';

final class CartController
{
  public static function index(RouteData $data): void
  {
    // Получаем массив всех настроек
    $settings = Settings::all();
    $pageTitle = "Корзина товаров";

    // Хлебные крошки
    $breadcrumbs = [
      ['title' => $pageTitle, 'url' => '#'],
    ];

    $cart = self::get();

    // Подключение шаблонов страницы
    include ROOT . "views/_page-parts/_head.tpl";
    include ROOT . "views/_parts/_header.tpl";
    include ROOT . "views/cart/cart.tpl";
    include ROOT . "views/_parts/_footer.tpl";
    include ROOT . "views/_page-parts/_foot.tpl";
  }

  public static function get (): array 
  {
    // Пользователь выполнил вход в профиль
    $isLoggedIn = isLoggedIn();

    // Определяем корзину
    Cart::set($isLoggedIn);

    // Получаем корзину
    $cart = Cart::get($isLoggedIn);

    return $cart;
  }
}