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
use Vvintage\Models\Auth\Auth;
use Vvintage\Models\User\User;
use Vvintage\Repositories\UserRepository;

require_once ROOT . './libs/functions.php';

final class CartController
{
  public static function index(RouteData $routeData): void
  {
    /**
     * Проверяем вход пользователя в профиль
     * @var bool
     */
    $isLoggedIn = Auth::isLoggedIn();
    $settings = Settings::all(); // Получаем массив всех настроек
 
    if ($isLoggedIn) 
    {
      print_r('Пользователь зашел в профиль');
      // Получаем информацию по продуктам из списка корзины 
      $userModel = $isLoggedIn ? Auth::getLoggedInUser() : null;
      // $loggedUser = $isLoggedIn ? Auth::getLoggedInUser() : null;
      $cartModel = self::loadCart($isLoggedIn, $userModel ?? null);
      $cartItems = $cartModel->getItems();

      $products = !empty($cartItems) ? ProductRepository::findByIds($cartItems) : [];
      $totalPrice = !empty($products) ? $cartModel->getTotalPrice($products) : 0;
    }

    if (!$isLoggedIn) {
      print_r('Пользователь не зашел в профиль');
      // Загружаем корзину
      $cartModel = self::loadCart($isLoggedIn, $loggedUser ?? null);

      // Получаем продукты
      $cartItems = $cartModel->getItems();
      
      $products = !empty($cartItems) ? ProductRepository::findByIds($cartItems) : [];
      $totalPrice = !empty($products) ? $cartModel->getTotalPrice($products) : 0;
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

  public static function loadCart(bool $isLoggedIn, User $user = null): Cart
  {
    $cartModel = new Cart(new UserRepository());

    if (!$isLoggedIn || !$user) {
      // Устанавливаем корзину пользователя в модель
      $cart = $cartModel->loadFromNotUser();
    
      return $cartModel;
    }

    // Устанавливаем корзину пользователя в модель
    $userId = $user->getId();
    $cartModel->loadFromUser($userId);

    // Получаем продукты и записываем в сессию
    // $cart = $cartModel->getItems();
    $_SESSION['cart'] = $cartModel->getItems();

    return $cartModel;
  }

  public static function addItem(int $productId, $routeData): void
  {
    $isLoggedIn = Auth::isLoggedIn();

    /**
     * Если пользователь залогинился - сохраняем модель User или null
     * @var User || NULL
    */
    $userModel = $isLoggedIn ? Auth::getLoggedInUser() : null; 

    /**
     * Получаем модель корзины
     * @var Cart
    */
    $cartModel = $userModel ? $userModel->getCartModel() : new Cart (new UserRepository);

    $cartModel->addToCart($productId, $userModel ?? null);
    // $cartModel->saveToSession();

    /** 
     *  Получаем корзину с новым товаром
     * @var array $cartUpdated 
    * */
    $cartUpdated = $cartModel->getItems();

    // Сохраняем корзину 
    // Если пользователь - в БД
    if ($user !== null) {
      $userRepository = $cartModel->getUserRepository();
      $userRepository->saveUserCart($userId, $cartUpdated);

      // Переадресация обратно на страницу товара (или корзины)
      header('Location: ' . HOST . 'shop/' . $productId);
      exit();
    }

    // Переадресация обратно на страницу товара (или корзины)
    header('Location: ' . HOST . 'shop/' . $productId);
    exit();
  }

}