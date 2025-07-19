<?php

declare(strict_types=1);

namespace Vvintage\Controllers\Orders;

use Vvintage\Routing\Router;
use Vvintage\Routing\RouteData;

/** Интерфейсы */
use Vvintage\Models\User\UserInterface;
use Vvintage\Store\UserItemsList\ItemsListStoreInterface;

/** Сервисы */
use Vvintage\Services\Cart\CartService;
use Vvintage\Services\Messages\FlashMessage;

/** Модели */
use Vvintage\Models\Cart\Cart;
use Vvintage\Models\Settings\Settings;

/** Хранилище */


require_once ROOT . './libs/functions.php';

final class OrdersController
{
    private CartService $cartService;
    private UserInterface $userModel;
    private Cart $cartModel;
    private array $cart;
    private ItemsListStoreInterface $cartStore;
    private FlashMessage $notes;
  

    public function __construct(
      CartService $cartService, 
      UserInterface $userModel,
      Cart $cartModel,
      array $cart,
      ItemsListStoreInterface $cartStore,
      FlashMessage $notes
    )
    {
      $this->cartService = $cartService;
      $this->userModel = $userModel;
      $this->cartModel = $cartModel;
      $this->cart = $cart;
      $this->cartStore = $cartStore;
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
   
      // Показываем страницу
      self::renderPage($routeData, $products, $this->cartModel, $totalPrice);
    }

    private function renderPage ($routeData, array $products, Cart $cartModel, int $totalPrice): void 
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
