<?php

declare(strict_types=1);

namespace Vvintage\Controllers\Cart;

use RedBeanPHP\R; // Подключаем readbean
use Vvintage\Routing\Router;
use Vvintage\Routing\RouteData;

/** Базовый контроллер страниц*/
use Vvintage\Controllers\Base\BaseController;

/** Репозитории */
use Vvintage\Repositories\UserRepository;
use Vvintage\Repositories\ProductRepository;

/** Абстракции */
use Vvintage\Models\Shared\AbstractUserItemsList;

/** Интерфейсы */
use Vvintage\Models\User\UserInterface;
use Vvintage\Store\UserItemsList\ItemsListStoreInterface;

/** Модели */
use Vvintage\Models\User\User;
use Vvintage\Models\User\GuestUser;
use Vvintage\Models\Settings\Settings;
use Vvintage\Models\Shop\Catalog;
use Vvintage\Models\Cart\Cart;

/** Сервисы */
use Vvintage\Services\Auth\SessionManager;
use Vvintage\Services\Cart\CartService;
use Vvintage\Services\Messages\FlashMessage;

/** Хранилище */
use Vvintage\Store\UserItemsList\GuestItemsListStore;
use Vvintage\Store\UserItemsList\UserItemsListStore;


require_once ROOT . './libs/functions.php';

final class CartController extends BaseController
{
    private CartService $cartService;
    private UserInterface $userModel;
    private Cart $cartModel;
    private array $cart;
    private ItemsListStoreInterface $cartStore;
    private FlashMessage $notes;

    public function __construct(CartService $cartService, UserInterface $userModel, Cart $cartModel, array $cart, ItemsListStoreInterface $cartStore, FlashMessage $notes)
    {
      $this->cartService = $cartService;
      $this->userModel = $userModel;
      $this->cartModel = $cartModel;
      $this->cart = $cart;
      $this->cartStore = $cartStore;
      $this->notes = $notes;
    }

    private function renderPage (RouteData $routeData, array $products, Cart $cartModel, int $totalPrice): void 
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
      $this->renderLayout('cart/cart', [
            'products' => $products,
            'pageTitle' => 'Корзина',
      ]);
      // include ROOT . "templates/_page-parts/_head.tpl";
      // include ROOT . "views/_parts/_header.tpl";
      // include ROOT . "views/cart/cart.tpl";
      // include ROOT . "views/_parts/_footer.tpl";
      // include ROOT . "views/_page-parts/_foot.tpl";
    }


    public function index(RouteData $routeData): void
    {
      // Получаем продукты
      $products = $this->cartService->getListItems();
      $totalPrice = $this->cartService->getCartTotalPrice($products, $this->cartModel);

      // Показываем страницу
      self::renderPage($routeData, $products, $this->cartModel, $totalPrice);
    }

    public function addItem(int $productId, $routeData): void
    {
      $this->cartService->addItem($productId);

      // Переадресация обратно на страницу товара
      header('Location: ' . HOST . 'shop/' . $productId);
      exit();
    }

    public function removeItem(int $productId): void
    {
      $this->cartService->removeItem($productId);

      // Переадресация обратно на страницу товара
      header('Location: ' . HOST . 'cart');
      exit();
    }

}
