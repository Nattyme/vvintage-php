<?php

declare(strict_types=1);

namespace Vvintage\Controllers\Cart;

use RedBeanPHP\R; // Подключаем readbean
use Vvintage\Routing\Router;
use Vvintage\Routing\RouteData;
use Vvintage\Repositories\ProductRepository;
use Vvintage\Models\Settings\Settings;
use Vvintage\Models\Shop\Catalog;
use Vvintage\Models\Shared\AbstractUserItemsList;
use Vvintage\Models\Cart\Cart;
use Vvintage\Services\Auth\SessionManager;
use Vvintage\Models\User\User;
use Vvintage\Models\User\GuestUser;
use Vvintage\Store\Cart\GuestCartStore;
use Vvintage\Store\Cart\UserCartStore;
use Vvintage\Store\Cart\CartStoreInterface;
use Vvintage\Models\User\UserInterface;
use Vvintage\Repositories\UserRepository;
use Vvintage\Services\Messages\FlashMessage;

require_once ROOT . './libs/functions.php';

final class CartController
{
    private UserInterface $userModel;
    private Cart $cartModel;
    private array $cart;
    private CartStoreInterface $cartStore;
    private FlashMessage $notes;

    public function __construct(UserInterface $userModel, Cart $cartModel, array $cart, CartStoreInterface $cartStore, FlashMessage $notes)
    {
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
      include ROOT . "templates/_page-parts/_head.tpl";
      include ROOT . "views/_parts/_header.tpl";
      include ROOT . "views/cart/cart.tpl";
      include ROOT . "views/_parts/_footer.tpl";
      include ROOT . "views/_page-parts/_foot.tpl";
    }


    public function index(RouteData $routeData): void
    {
      // Получаем продукты
      $products = !empty($this->cart) ? ProductRepository::findByIds($this->cart) : [];
      $totalPrice = !empty($products) ? $this->cartModel->getTotalPrice($products) : 0;

      // Показываем страницу
      self::renderPage($routeData, $products, $this->cartModel, $totalPrice);
    }

    public function addItem(int $productId, $routeData): void
    {
      // Добавляем новый продукт
      $this->cartModel->addItem($productId);

      // Сохраняем в хранилище
      $this->cartStore->save($this->cartModel, $this->userModel);

      // Переадресация обратно на страницу товара
      header('Location: ' . HOST . 'shop/' . $productId);
      exit();
    }

    public function removeItem(int $productId): void
    {
        // Удаляем товар
        $this->cartModel->removeItem($productId);

        $this->cartStore->save($this->cartModel, $this->userModel);

        // Переадресация обратно на страницу товара
        header('Location: ' . HOST . 'cart');
        exit();
    }

}
