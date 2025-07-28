<?php

declare(strict_types=1);

namespace Vvintage\Controllers\Home;

use RedBeanPHP\R; // Подключаем readbean
use Vvintage\Routing\Router;
use Vvintage\Routing\RouteData;

/** Базовый контроллер страниц*/
use Vvintage\Controllers\Base\BaseController;

/** Репозитории */
// use Vvintage\Repositories\UserRepository;
// use Vvintage\Repositories\ProductRepository;

/** Абстракции */
// use Vvintage\Models\Shared\AbstractUserItemsList;

/** Интерфейсы */
// use Vvintage\Models\User\UserInterface;
// use Vvintage\Store\UserItemsList\ItemsListStoreInterface;

/** Модели */
// use Vvintage\Models\User\User;
// use Vvintage\Models\User\GuestUser;
// use Vvintage\Models\Shop\Catalog;
// use Vvintage\Models\Cart\Cart;

/** Сервисы */
// use Vvintage\Services\Auth\SessionManager;
// use Vvintage\Services\Cart\CartService;
// use Vvintage\Services\Page\Breadcrumbs;
// use Vvintage\Services\Messages\FlashMessage;

/** Хранилище */
// use Vvintage\Store\UserItemsList\GuestItemsListStore;
// use Vvintage\Store\UserItemsList\UserItemsListStore;


require_once ROOT . './libs/functions.php';

final class HomeController extends BaseController
{
    // private CartService $cartService;
    // private UserInterface $userModel;
    // private Cart $cartModel;
    // private array $cart;
    // private ItemsListStoreInterface $cartStore;

    public function __construct(
      
    )
    {
      parent::__construct(); // Важно!
    }

    private function renderPage (RouteData $routeData): void 
    {  
      // Название страницы
      $pageTitle = 'Главная';

      // Подключение шаблонов страницы
      $this->renderLayout('main/index', [
            'pageTitle' => $pageTitle,
            'routeData' => $routeData
      ]);
    }


    public function index(RouteData $routeData): void
    {
      // Получаем продукты
      // $products = $this->cartService->getListItems();
      // $totalPrice = $this->cartService->getCartTotalPrice($products, $this->cartModel);

      // Показываем страницу
      $this->renderPage($routeData);
    }

}
