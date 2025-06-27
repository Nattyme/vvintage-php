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

    $products = self::get();

    // Подключение шаблонов страницы
    include ROOT . "views/_page-parts/_head.tpl";
    include ROOT . "views/_parts/_header.tpl";
    include ROOT . "views/cart/cart.tpl";
    include ROOT . "views/_parts/_footer.tpl";
    include ROOT . "views/_page-parts/_foot.tpl";
  }

  public static function get (): array 
  {
    // Проверяем вход пользователя в профиль
    $isLoggedIn = isLoggedIn();

    // Создаем объект корзины
    $cart = new Cart();
    $cartData = $cart->set($isLoggedIn);

    // Получаем информацию по продуктам из списка корзины 
    $products = ProductRepository::findByIds($cartData);

    return $products;
  }
}