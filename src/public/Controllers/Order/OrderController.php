<?php

declare(strict_types=1);

namespace Vvintage\public\Controllers\Order;

use Vvintage\Routing\RouteData;

/** Базовый контроллер страниц*/
use Vvintage\public\Controllers\Base\BaseController;

/** Интерфейсы */
use Vvintage\Contracts\User\UserInterface;
use Vvintage\Contracts\User\UserItemsListStoreInterface;

/** Сервисы */
use Vvintage\Services\Order\OrderService;
use Vvintage\Services\Cart\CartService;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Session\SessionService;
use Vvintage\Services\Validation\NewOrderValidator;
use Vvintage\Services\Page\Breadcrumbs;
use Vvintage\Services\Page\PageService;
use Vvintage\Services\SEO\SeoService;

/** Модели */
use Vvintage\Models\User\User;
use Vvintage\Models\User\GuestUser;
use Vvintage\Models\Cart\Cart;
use Vvintage\Models\Order\Order;
use Vvintage\Models\Settings\Settings;

/** Хранилище */

/** DTO */
use Vvintage\DTO\Order\OrderDTO;


require_once ROOT . './libs/functions.php';

final class OrderController extends BaseController
{
    private OrderService $orderService;
    private CartService $cartService;
    private UserInterface $userModel;
    private Cart $cartModel;
    private array $cart;
    private UserItemsListStoreInterface $cartStore;
    private NewOrderValidator $validator;
    private Breadcrumbs $breadcrumbsService;
    protected PageService $pageService;
  

    public function __construct(
      FlashMessage $flash,
      SessionService $sessionService,
      OrderService $orderService, 
      CartService $cartService, 
      UserInterface $userModel,
      Cart $cartModel,
      array $cart,
      UserItemsListStoreInterface $cartStore,
      NewOrderValidator $validator,
      Breadcrumbs $breadcrumbs
    )
    {
      $this->orderService = $orderService;
      $this->cartService = $cartService;
      $this->userModel = $userModel;
      $this->cartModel = $cartModel;
      $this->cart = $cart;
      $this->cartStore = $cartStore;
      $this->validator = $validator;
      $this->breadcrumbsService = $breadcrumbs;
      $this->pageService = new PageService();
      parent::__construct($flash, $sessionService, $this->pageService, $this->seoService); // Важно!
    }

    public function index(RouteData $routeData): void
    {
      $this->setRouteData($routeData);

      
      if(empty($this->cart)) $this->redirect('cart'); // Если корзина пуста, то редирект на корзину
      if($this->userModel instanceof GuestUser) $this->redirect('login'); // Если гость — редиректим

      // Получаем продукты
      $products = $this->cartService->getListItems();
      $totalPrice = $this->cartService->getCartTotalPrice($products, $this->cartModel);

      if(isset($_POST['submit'])) {
          try {
            $this->validator->validate($_POST);

            // Вызываем DTO
            $orderDTO = OrderDTO::fromForm($_POST, $this->cart, $totalPrice, $this->userModel->getId());
            $order = $this->orderService->create($orderDTO, $this->userModel);

            if ($order === null) throw new \Exception("Произошла ошибка при создании заказа.");

            // Очищаем корзину
            $cartModel = new Cart($this->cart);
            $this->cartModel->clear($this->userModel, $cartModel);
            $orderId = $order->export()['id'];

            $this->flash->pushSuccess('Заказ успешно создан.');
            $this->redirect('ordercreated', (string) $orderId);
          }
          catch(\Throwable $error) {
            $this->flash->pushError($error->getMessage());
            $this->redirect('neworder');
          }
      }

      // Название страницы
      $page = $this->pageService->getPageBySlug($routeData->uriModule);
      $pageTitle = $page['title'];

      $this->renderForm($pageTitle, $this->userModel, $routeData, $products, $this->cartModel, $totalPrice);
    }

    private function edit(Order $order, array $postData)
    {
      $this->orderService->edit($order, $postData);
    }

    public function renderCreated($routeData) 
    {
      $this->setRouteData($routeData);
      
      // Название страницы
      $page = $this->pageService->getPageBySlug($routeData->uriModule); 
      $pageTitle = $page['title'];

      // Хлебные крошки
      $breadcrumbs = $this->breadcrumbsService->generate($routeData, $pageTitle);

     
      // Получаем GET['id] 
      $new_order_id = $routeData->uriGet;

      // Если заказ не создан
      if (!$new_order_id || $new_order_id <= 0) {
        $this->flash->pushError('ID заказа не найден');
        $this->redirect('cart');
      }

      // Подключение шаблонов страницы
      $this->renderLayout('orders/created', [
            'pageTitle' => $pageTitle,
            'routeData' => $routeData,
            'breadcrumbs' => $breadcrumbs,
            'flash' => $this->flash,
            'navigation' => $this->pageService->getLocalePagesNavTitles(),
            'currentLang' =>  $this->pageService->currentLang,
            'languages' => $this->pageService->languages
      ]);
    }

    private function renderForm ($pageTitle, $userModel, $routeData, array $products, Cart $cartModel, int $totalPrice): void 
    {  

      // Хлебные крошки
      $breadcrumbs = $this->breadcrumbsService->generate($routeData, $pageTitle);

      // Подключение шаблонов страницы
      $this->renderLayout('orders/new', [
            'pageTitle' => $pageTitle,
            'user' => $this->userModel,
            'cartModel' => $cartModel,
            'routeData' => $routeData,
            'products' => $products,
            'totalPrice' => $totalPrice,
            'breadcrumbs' => $breadcrumbs,
            'flash' => $this->flash,
            'navigation' => $this->pageService->getLocalePagesNavTitles(),
            'currentLang' =>  $this->pageService->currentLang,
            'languages' => $this->pageService->languages
      ]);
    }
}
