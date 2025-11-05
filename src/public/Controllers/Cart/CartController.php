<?php

declare(strict_types=1);

namespace Vvintage\Public\Controllers\Cart;


use Vvintage\Routing\RouteData;

/** Базовый контроллер страниц*/
use Vvintage\Public\Controllers\Base\BaseController;

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
use Vvintage\Public\Services\Cart\CartService;
use Vvintage\Public\Services\Page\Breadcrumbs;
use Vvintage\Public\Services\Product\ProductImageService;
use Vvintage\Public\Services\Page\PageService;
use Vvintage\Public\Services\SEO\SeoService;
use Vvintage\Utils\Services\FlashMessage\FlashMessage;
use Vvintage\Utils\Services\Session\SessionService;

/** Хранилище */
use Vvintage\Store\UserItemsList\GuestItemsListStore;
use Vvintage\Store\UserItemsList\UserItemsListStore;


final class CartController extends BaseController
{
    private CartService $cartService;
    private UserInterface $userModel;
    private Cart $cartModel;
    private array $cart;
    private UserItemsListStoreInterface $cartStore;
    private Breadcrumbs $breadcrumbsService;
    protected PageService $pageService;
    protected SeoService $seoService;

    public function __construct(
      FlashMessage $flash,
      SessionService $sessionService,
      CartService $cartService, 
      UserInterface $userModel, 
      Cart $cartModel, 
      array $cart, 
      UserItemsListStoreInterface $cartStore, 
      Breadcrumbs $breadcrumbs,
      SeoService $seoService
    )
    {
      $this->cartService = $cartService;
      $this->userModel = $userModel;
      $this->cartModel = $cartModel;
      $this->cart = $cart;
      $this->cartStore = $cartStore;
      $this->breadcrumbsService = $breadcrumbs;
      $this->pageService = new PageService();
      $this->seoService = $seoService;
      parent::__construct($flash, $sessionService, $this->pageService, $this->seoService); // Важно!
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
      $this->flash->pushSuccess('Товар добавлен в корзину');
      $this->redirect('shop/' . $productId);
    }

    public function removeItem(int $productId, RouteData $routeData): void
    {
      $this->cartService->removeItem($productId);

      // Уведомление и переадресация в корзину
      $this->flash->pushSuccess('Товар удален из корзины');
      $this->redirect('cart');
    }

}
