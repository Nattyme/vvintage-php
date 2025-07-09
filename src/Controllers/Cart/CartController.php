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
use Vvintage\Services\Auth\SessionManager;
use Vvintage\Models\User\User;
use Vvintage\Models\User\GuestUser;
use Vvintage\Store\Cart\GuestCartStore;
use Vvintage\Store\Cart\UserCartStore;
use Vvintage\Store\Cart\CartStoreInterface;
use Vvintage\Models\User\UserInterface;
use Vvintage\Repositories\UserRepository;

require_once ROOT . './libs/functions.php';

final class CartController
{
    public static function index(RouteData $routeData): void
    {
      /**
       * Получаем модель пользователя - гость или залогиненный
       * @var UserInreface $userModel
      */
      $userModel = SessionManager::getLoggedInUser();
    
      // Получаем корзину и ее модель
      $cartModel = $userModel->getCartModel();
      $cart = $userModel->getCart();

      // Получаем продукты
      $products = !empty($cart) ? ProductRepository::findByIds($cart) : [];
      $totalPrice = !empty($products) ? $cartModel->getTotalPrice($products) : 0;

      // Показываем страницу
      self::renderPage($routeData, $products, $cartModel, $totalPrice);
    }

    private static function renderPage (RouteData $routeData, array $products, Cart $cartModel, int $totalPrice): void 
    {  
      /**
        * Проверяем вход пользователя в профиль
        * @var bool
      */
      $settings = Settings::all(); // Получаем массив всех настроек
      
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

    public static function addItem(int $productId, $routeData): void
    {
  
      /**
       * Получаем модель пользователя - гость или залогоиненный
       * @var UserInreface $userModel
      */
      $userModel = SessionManager::getLoggedInUser();
    
      // Получаем корзину и ее модель
      $cartModel = $userModel->getCartModel();
      $cart = $userModel->getCart();

      // Добавляем новый продукт
      $cartModel->addCartItem($productId);

      /**
       * Сохраняем в нужное хранилище
       * @var CartStoreInterface $cartStore;
       */
      $cartStore = ($userModel instanceof User) 
                    ? new UserCartStore( new UserRepository() ) 
                    : new GuestCartStore();

      $cartStore->save($cartModel, $userModel);

      // Переадресация обратно на страницу товара
      header('Location: ' . HOST . 'shop/' . $productId);
      exit();
    }

    public static function removeItem(int $productId): void
    {
        /**
         * Получаем модель пользователя - гость или залогиненный
         * @var UserInreface $userModel
        */
        $userModel = SessionManager::getLoggedInUser();

        // Получаем корзину и ее модель
        $cartModel = $userModel->getCartModel();
        $cart = $userModel->getCart();

        // Удаляем товар
        $cartModel->removeCartItem($productId);

        /**
         * Сохраняем в нужное хранилище
         * @var CartStoreInterface $cartStore;
         */
        $cartStore = ($userModel instanceof User) 
                     ? new UserCartStore( new UserRepository() ) 
                     : new GuestCartStore();

        $cartStore->save($cartModel, $userModel);

        // Переадресация обратно на страницу товара
        header('Location: ' . HOST . 'cart');
        exit();
    }

}
