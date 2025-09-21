<?php

declare(strict_types=1);

namespace Vvintage\Controllers\Favorites;

/** Базовый контроллер страниц*/
use Vvintage\Controllers\Base\BaseController;

/** Контракты */
use Vvintage\Contracts\User\UserInterface;
use Vvintage\Contracts\User\UserItemsListStoreInterface;

use Vvintage\Routing\Router;
use Vvintage\Routing\RouteData;
use Vvintage\Models\Shop\Catalog;
use Vvintage\Models\Favorites\Favorites;
use Vvintage\Models\User\User;
use Vvintage\Models\User\GuestUser;

/** Хранилище */
use Vvintage\Store\UserItemsList\GuestItemsListStore;
use Vvintage\Store\UserItemsList\UserItemsListStore;

use Vvintage\Repositories\User\UserRepository;
use Vvintage\Services\Messages\FlashMessage;

/** Сервисы */
use Vvintage\Services\Favorites\FavoritesService;
use Vvintage\Services\Page\Breadcrumbs;
use Vvintage\Services\Product\ProductImageService;
use Vvintage\Services\Product\ProductService;


/** Абстракции */
use Vvintage\Models\Shared\AbstractUserItemsList;


require_once ROOT . './libs/functions.php';

final class FavoritesController extends BaseController
{
    private FavoritesService $favService;
    private UserInterface $userModel;
    private Favorites $favModel;
    private array $fav_list;
    private UserItemsListStoreInterface $favStore;
    private Breadcrumbs $breadcrumbsService;

    public function __construct(
      FavoritesService $favService, 
      UserInterface $userModel, 
      Favorites $favModel, 
      array $fav_list, 
      UserItemsListStoreInterface $favStore, 
      Breadcrumbs $breadcrumbs
      )
    {
      parent::__construct(); // Важно!
      $this->favService = $favService;
      $this->userModel = $userModel;
      $this->favModel = $favModel;
      $this->fav_list = $fav_list;
      $this->favStore = $favStore;
      $this->breadcrumbsService = $breadcrumbs;
    }

    public function index(RouteData $routeData): void
    {
      $this->setRouteData($routeData); // <-- передаём routeData

      // Получаем продукты
      $productService = new ProductService();
      $products = !empty($this->fav_list) ?  $productService->getProductsByIds($this->fav_list) : [];

      // Показываем страницу
      $this->renderPage($routeData, $products, $this->favModel);
    }

    private function renderPage (RouteData $routeData, array $products, Favorites $favModel): void 
    {  
      // Название страницы
      $pageTitle = 'Избранное';

      // Хлебные крошки
      $breadcrumbs = $this->breadcrumbsService->generate($routeData, $pageTitle);

 
      // Формируем единую модель для передачи в шаблон
 
      $viewModel = [
        'products' => $products
      ];

      // Подключение шаблонов страницы
      $this->renderLayout('favorites/favorites', [
            'favModel' => $this->favModel,
            'pageTitle' => $pageTitle,
            'routeData' => $routeData,
            'breadcrumbs' => $breadcrumbs,
            'viewModel' => $viewModel,
            'flash' => $this->flash
      ]);
     
    }

    public function addItem(int $productId, $routeData): void
    {
      // Передаем ключ для сохранения куки и id продукта
      $this->favService->addItem($productId);

      // Переадресация обратно на страницу товара
      header('Location: ' . HOST . 'shop/' . $productId);
      exit();
    }

    public function removeItem(int $productId): void
    {      

        // Удаляем товар
        $this->favService->removeItem($productId);
        // $this->favStore->save($this->favModel, $this->userModel);

        // Переадресация обратно на страницу товара
        header('Location: ' . HOST . 'favorites');
        exit();
    }

}
