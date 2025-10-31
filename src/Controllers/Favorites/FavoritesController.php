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
use Vvintage\Services\Page\PageService;
use Vvintage\Services\SEO\SeoService;


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
    private PageService $pageService;
    private SeoService $seoService;

    public function __construct(
      FavoritesService $favService, 
      UserInterface $userModel, 
      Favorites $favModel, 
      array $fav_list, 
      UserItemsListStoreInterface $favStore, 
      Breadcrumbs $breadcrumbs,
      SeoService $seoService
    )
    {
      parent::__construct(); // Важно!
      $this->favService = $favService;
      $this->userModel = $userModel;
      $this->favModel = $favModel;
      $this->fav_list = $fav_list;
      $this->favStore = $favStore;
      $this->breadcrumbsService = $breadcrumbs;
      $this->pageService = new PageService();
      $this->seoService = $seoService;
    }

    public function index(RouteData $routeData): void
    {
      $this->setRouteData($routeData); // <-- передаём routeData

      // Получаем продукты
      $productService = new ProductService();
      $products = !empty($this->fav_list) ? $this->favService->getListItems($this->fav_list) : [];

      // Показываем страницу
      $this->renderPage($routeData, $products, $this->favModel);
    }

    private function renderPage (RouteData $routeData, array $products, Favorites $favModel): void 
    {  
      // Название страницы
      $page = $this->pageService->getPageBySlug($routeData->uriModule);
      $pageModel = $this->pageService->getPageModelBySlug( $routeData->uriModule );
      $seo = $this->seoService->getSeoForPage('cart', $pageModel);

      // Название страницы
      $pageTitle = $seo->title;

      // Хлебные крошки
      $breadcrumbs = $this->breadcrumbsService->generate($routeData, $pageTitle);

 
      // Формируем единую модель для передачи в шаблон

      $viewModel = [
        'products' => $products
      ];

      // Подключение шаблонов страницы
      $this->renderLayout('favorites/favorites', [
            'seo' => $seo,
            'pageTitle' => $pageTitle,
            'favModel' => $this->favModel,
            'pageTitle' => $pageTitle,
            'routeData' => $routeData,
            'breadcrumbs' => $breadcrumbs,
            'navigation' => $this->pageService->getLocalePagesNavTitles(),
            'viewModel' => $viewModel,
            'flash' => $this->flash,
            'currentLang' =>  $this->pageService->currentLang,
            'languages' => $this->pageService->languages
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
