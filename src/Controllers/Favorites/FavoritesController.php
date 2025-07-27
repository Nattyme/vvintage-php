<?php

declare(strict_types=1);

namespace Vvintage\Controllers\Favorites;

/** Базовый контроллер страниц*/
use Vvintage\Controllers\Base\BaseController;

use Vvintage\Routing\Router;
use Vvintage\Routing\RouteData;
use Vvintage\Repositories\ProductRepository;
use Vvintage\Models\Shop\Catalog;
use Vvintage\Models\Favorites\Favorites;
use Vvintage\Services\Auth\SessionManager;
use Vvintage\Models\User\User;
use Vvintage\Models\User\GuestUser;
// use Vvintage\Store\Favorites\GuestFavoritesStore;
// use Vvintage\Store\Favorites\UserFavoritesStore;
// use Vvintage\Store\Favorites\FavoritesStoreInterface;
/** Хранилище */
use Vvintage\Store\UserItemsList\GuestItemsListStore;
use Vvintage\Store\UserItemsList\UserItemsListStore;

use Vvintage\Repositories\UserRepository;
use Vvintage\Services\Messages\FlashMessage;

/** Сервисы */
use Vvintage\Services\Favorites\FavoritesService;
use Vvintage\Services\Page\Breadcrumbs;


/** Абстракции */
use Vvintage\Models\Shared\AbstractUserItemsList;

/** Интерфейсы */
use Vvintage\Models\User\UserInterface;
use Vvintage\Store\UserItemsList\ItemsListStoreInterface;


require_once ROOT . './libs/functions.php';

final class FavoritesController extends BaseController
{
    private FavoritesService $favService;
    private UserInterface $userModel;
    private Favorites $favModel;
    private array $fav_list;
    private ItemsListStoreInterface $favStore;
    private FlashMessage $notes;
    private Breadcrumbs $breadcrumbsService;

    public function __construct(
      FavoritesService $favService, 
      UserInterface $userModel, 
      Favorites $favModel, 
      array $fav_list, 
      ItemsListStoreInterface $favStore, 
      FlashMessage $notes,
      Breadcrumbs $breadcrumbs
      )
    {
      parent::__construct(); // Важно!
      $this->favService = $favService;
      $this->userModel = $userModel;
      $this->favModel = $favModel;
      $this->fav_list = $fav_list;
      $this->favStore = $favStore;
      $this->notes = $notes;
      $this->breadcrumbsService = $breadcrumbs;
    }

    public function index(RouteData $routeData): void
    {
     
      // Получаем продукты
      $products = !empty($this->fav_list) ? ProductRepository::findByIds($this->fav_list) : [];

      // Показываем страницу
      $this->renderPage($routeData, $products, $this->favModel);
    }

    private function renderPage (RouteData $routeData, array $products, Favorites $favModel): void 
    {  
      // Название страницы
      $pageTitle = 'Избранное';

      // Хлебные крошки
      $breadcrumbs = $this->breadcrumbsService->generate($routeData, $pageTitle);

      // Подключение шаблонов страницы
      $this->renderLayout('favorites/favorites', [
            'favModel' => $this->favModel,
            'pageTitle' => $pageTitle,
            'routeData' => $routeData,
            'breadcrumbs' => $breadcrumbs,
            'products' => $products
      ]);
  
      // Подключение шаблонов страницы
      // include ROOT . "views/favorites/favorites.tpl";
     
    }

    public function addItem(int $productId, $routeData): void
    {
      // Передаем ключ для сохранения куки и id продукта
      $this->favService->addItem($productId);

      // Добавляем новый продукт
      // $this->favModel->addItem($productId);
      // $this->favStore->save($this->favModel, $this->userModel);

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
