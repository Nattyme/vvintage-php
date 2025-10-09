<?php

declare(strict_types=1);

namespace Vvintage\Controllers\Order;

use Vvintage\Routing\Router;
use Vvintage\Routing\RouteData;

/** Базовый контроллер страниц*/
use Vvintage\Controllers\Base\BaseController;

/** Интерфейсы */
use Vvintage\Contracts\User\UserInterface;
use Vvintage\Contracts\User\UserItemsListStoreInterface;

/** Сервисы */
use Vvintage\Services\Order\OrderService;
use Vvintage\Services\Cart\CartService;
use Vvintage\Services\Messages\FlashMessage;
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
    private PageService $pageService;
  

    public function __construct(
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
      parent::__construct(); // Важно!
      $this->orderService = $orderService;
      $this->cartService = $cartService;
      $this->userModel = $userModel;
      $this->cartModel = $cartModel;
      $this->cart = $cart;
      $this->cartStore = $cartStore;
      $this->validator = $validator;
      $this->breadcrumbsService = $breadcrumbs;
      $this->pageService = new PageService();
    }

    public function index(RouteData $routeData): void
    {
      $this->setRouteData($routeData);
      
      if(empty($this->cart)) {
        header('Location: ' . HOST . 'cart');
        exit();
      }
    
      // Получаем продукты
      $products = $this->cartService->getListItems();
      $totalPrice = $this->cartService->getCartTotalPrice($products, $this->cartModel);

      $page = $this->pageService->getPageBySlug($routeData->uriModule);
      $pageTitle = $page['title'];
       

      if (!isRequestMethod('post') || !$this->validator->validate($_POST)) {
        // Показываем страницу
        $this->renderForm($pageTitle, $this->userModel, $routeData, $products, $this->cartModel, $totalPrice);
        return;
      } 
      
      if($this->userModel instanceof GuestUser) {
        header('Location: ' . HOST . 'login');
        exit();
      }


      // Вызываем DTO
      $orderDTO = OrderDTO::fromForm($_POST, $this->cart, $totalPrice, $this->userModel->getId());
      // $orderDTO->validate();

      $order = $this->orderService->create($orderDTO, $this->userModel);

      if ($order !== null) {
          // Очищаем корзину
          $cartModel = new Cart($this->cart);
          $this->cartModel->clear($this->userModel, $cartModel);

          header('Location: ' . HOST . 'ordercreated?id=' . $order->export()['id']);
          exit();
      } 
      $page = $this->pageService->getPageBySlug($routeData->uriModule);


      // сообщение об ошибке
      $this->flash->pushError("Произошла ошибка при создании заказа.");
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
      $pageTitle = 'Заказ оформлен!';
      $page = $this->pageService->getPageBySlug($routeData->uriModule); 
      $pageTitle = $page['title'];

      // Хлебные крошки
      $breadcrumbs = $this->breadcrumbsService->generate($routeData, $pageTitle);

      
      // Получаем GET['id] 
      $new_order_id = get('id', 'int');

      // Если заказ не создан
      if (!$new_order_id || $new_order_id <= 0) {
        $this->flash->pushError('ID заказа не найден');
        header('Location: ' . HOST);
        exit();
      }

      // Подключение шаблонов страницы
      $this->renderLayout('orders/created', [
            'pageTitle' => $pageTitle,
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
            'pageTitle' => $pageTitle,
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
