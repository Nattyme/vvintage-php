<?php

declare(strict_types=1);

namespace Vvintage\Controllers\Cart;

use RedBeanPHP\R; // Подключаем readbean
use Vvintage\Routing\Router;
use Vvintage\Routing\RouteData;

/** Базовый контроллер страниц*/
use Vvintage\Controllers\Base\BaseController;

/* Абстракции */
use Vvintage\Models\Shared\AbstractUserItemsList;

/** Контракты */
use Vvintage\Contracts\User\UserInterface;
use Vvintage\Contracts\User\UserItemsListStoreInterface;

/** Модели */
use Vvintage\Models\User\User;
use Vvintage\Models\User\GuestUser;
use Vvintage\Models\Shop\Catalog;
use Vvintage\Models\Cart\Cart;

/** Сервисы */
use Vvintage\Services\Cart\CartService;
use Vvintage\Services\Page\Breadcrumbs;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Product\ProductImageService;
use Vvintage\Services\Page\PageService;
use Vvintage\Services\SEO\SeoService;

/** Хранилище */
use Vvintage\Store\UserItemsList\GuestItemsListStore;
use Vvintage\Store\UserItemsList\UserItemsListStore;


require_once ROOT . './libs/functions.php';

final class CartController extends BaseController
{
    private FlashMessage $flash;
    private CartService $cartService;
    private UserInterface $userModel;
    private Cart $cartModel;
    private array $cart;
    private UserItemsListStoreInterface $cartStore;
    private Breadcrumbs $breadcrumbsService;
    private PageService $pageService;
    private SeoService $seoService;

    public function __construct(
      FlashMessage $flash,
      CartService $cartService, 
      UserInterface $userModel, 
      Cart $cartModel, 
      array $cart, 
      UserItemsListStoreInterface $cartStore, 
      Breadcrumbs $breadcrumbs,
      SeoService $seoService
    )
    {
      parent::__construct(); // Важно!
      $this->cartService = $cartService;
      $this->userModel = $userModel;
      $this->cartModel = $cartModel;
      $this->cart = $cart;
      $this->cartStore = $cartStore;
      $this->breadcrumbsService = $breadcrumbs;
      $this->pageService = new PageService();
      $this->seoService = $seoService;
      $this->flash = $flash;
    }

    public function index(RouteData $routeData): void
    {
      // Получаем продукты
      $products = $this->cartService->getListItems();
 
      $totalPrice = $this->cartService->getCartTotalPrice($products, $this->cartModel);
      $this->setRouteData($routeData); // <-- передаём routeData

      // Показываем страницу
      $this->renderPage($routeData, $products, $this->cartModel, $totalPrice);
    }

    private function renderPage (RouteData $routeData, array $products, Cart $cartModel, int $totalPrice): void 
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
          'products' => $products,
          'totalPrice' => $totalPrice
      ];

      // Подключение шаблонов страницы
      $this->renderLayout('cart/cart', [
            'seo' => $seo,
            'cartModel' => $this->cartModel,
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


   

    public function addItem(int $productId, RouteData $routeData): void
    {
      $this->cartService->addItem($productId);

      // Переадресация обратно на страницу товара
      header('Location: ' . HOST . 'shop/' . $productId);
      exit();
    }

    public function removeItem(int $productId, RouteData $routeData): void
    {
      $this->cartService->removeItem($productId);

      // Переадресация обратно на страницу товара
      header('Location: ' . HOST . 'cart');
      exit();
    }

}
