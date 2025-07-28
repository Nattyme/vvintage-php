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
use Vvintage\Repositories\ProductRepository;
use Vvintage\Repositories\PostRepository;

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
      $pageTitle = 'Vvintage - интернет магазин. Главная страница';

      // Подключение шаблонов страницы
      $this->renderLayout('main/index', [
            'pageTitle' => $pageTitle,
            'routeData' => $routeData
      ]);
    }


    public function index(RouteData $routeData): void
    {
            // Получим категории
      $categories = R::find('categories', 'parent_id IS NULL');
dd($categories);
      $products = $this->getNewProducts();
dd($products);
      // Делаем запрос в БД для получения постов
      $posts = $this->getNewPosts();
dd($posts);
      // Показываем страницу
      $this->renderPage($routeData);
    }

    private function getCategories(): array
    {

    } 

    private function getNewProducts(): array
    {
      
      $productsAtHome = 4;
      $repository = new ProductRepository();
      $pagination = pagination($productsAtHome, 'products');

      // Получим новинки магазина
      return $repository->findAll($pagination);
    }

    private function getNewPosts(): array
    {
      $postsAtHome = 4;
      $repository = new PostRepository();
      $pagination = pagination($postsAtHome, 'posts');

      return $repository->findAll($pagination);
    }

}
