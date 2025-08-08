<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Profile;

use Vvintage\Routing\RouteData;


/** Базовый контроллер страниц*/
use Vvintage\Controllers\Base\BaseController;

use Vvintage\Models\User\User;
use Vvintage\Models\Address\Address;


use Vvintage\Services\Auth\SessionManager;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Page\Breadcrumbs;
use Vvintage\Repositories\User\UserRepository;
use Vvintage\Repositories\Order\OrderRepository;
use Vvintage\Repositories\Product\ProductRepository;
use Vvintage\Models\Order\Order;

require_once ROOT . './libs/functions.php';


final class ProfileController extends BaseController
{ 
  private OrderRepository $orderRepository;
  private UserRepository $userRepository;
  private SessionManager $sessionManager;
  private Breadcrumbs $breadcrumbsService;
  private FlashMessage $notes;

  public function __construct(SessionManager $sessionManager, Breadcrumbs $breadcrumbs, FlashMessage $notes)
  {
    parent::__construct(); // Важно!
    $this->orderRepository = new OrderRepository();
    $this->userRepository = new UserRepository();
    $this->sessionManager = $sessionManager;
    $this->breadcrumbsService = $breadcrumbs;
    $this->notes = $notes;
  }

  private function renderProfile (RouteData $routeData, ?User $userModel, ?array $orders): void 
  {  
      // Название страницы
      $pageTitle = 'Профиль пользователя';
      $pageClass = "profile-page";

      // Хлебные крошки
      $breadcrumbs = $this->breadcrumbsService->generate($routeData, $pageTitle);

      // Подключение шаблонов страницы
      $this->renderLayout('profile/profile', [
            'pageTitle' => $pageTitle,
            'routeData' => $routeData,
            'breadcrumbs' => $breadcrumbs,
            'pageClass' => $pageClass,
            'userModel' => $userModel,
            'orders' => $orders
      ]);
  }

  private function renderProfileEdit (RouteData $routeData, ?User $userModel): void 
  {  
      // Название страницы
      $pageTitle = 'Редактирование профиля пользователя';
      $pageClass = "profile-page";

      // Хлебные крошки
      $breadcrumbs = $this->breadcrumbsService->generate($routeData, $pageTitle);

      // Подключение шаблонов страницы
      $this->renderLayout('profile/profile-edit', [
            'pageTitle' => $pageTitle,
            'routeData' => $routeData,
            'breadcrumbs' => $breadcrumbs,
            'pageClass' => $pageClass,
            'userModel' => $userModel
      ]);
  }

  private function renderOrder (RouteData $routeData, ?Order $order, array $products): void 
  {  
      // Название страницы
      $pageTitle = "Заказ &#8470;" . $order->getId() . "&#160; от &#160;" . rus_date('j F Y', $order->getDateTime()->getTimestamp());
      $pageClass = "profile-page";

      // Хлебные крошки
      $breadcrumbs = $this->breadcrumbsService->generate($routeData, $pageTitle);

      // Подключение шаблонов страницы
      $this->renderLayout('profile/profile-order', [
            'pageTitle' => $pageTitle,
            'routeData' => $routeData,
            'breadcrumbs' => $breadcrumbs,
            'pageClass' => $pageClass,
            'order' => $order,
            'products' => $products
      ]);

  }


  public function index(RouteData $routeData)
  {
    $orders = null;
    $userModel = null;
    $isLoggedUser = $this->sessionManager->isLoggedIn();
    $this->setRouteData($routeData); // <-- передаём routeData

    if($isLoggedUser) {
      $userModel = $this->sessionManager->getLoggedInUser();
      if(!$userModel) 
      {
        header("Location: " . HOST . 'login');
      };
      $id = $userModel->getId();

      $orders = $this->orderRepository->getOrdersByUserId($id);
    } else {
      header('Location: ' . HOST . 'login');
    }
    
    $this->renderProfile($routeData, $userModel, $orders);
  }

  public function edit(RouteData $routeData)
  {    
    $orders = null;
    $userModel = null;
    $isLoggedUser = $this->sessionManager->isLoggedIn();

    $this->setRouteData($routeData); // <-- передаём routeData

    if($isLoggedUser) {
      $userModel = $this->sessionManager->getLoggedInUser();
      $id = $userModel->getId();
      $address = $userModel->getAddress();

      if(!$address) {
        $this->userRepository->ensureUserHasAddress($userModel);
      }

      $orders = $this->orderRepository->getOrdersByUserId($id);
    } else {
      header('Location: ' . HOST . 'login');
    }

    $addressModel = $userModel->getAddress();

    $this->renderProfileEdit($routeData, $userModel);

  }

  public function order(RouteData $routeData)
  {
      // Если ID нет - выходим
      if ( !isset($_GET['id']) || empty($_GET['id'])) {
        header('Location: ' . HOST . 'profile');
        exit();
      }

      $userModel = null;
      $isLoggedUser = $this->sessionManager->isLoggedIn();

      if(!$isLoggedUser) {
        header('Location: ' . HOST . 'login');
      }

      $userModel = $this->sessionManager->getLoggedInUser();
      $userId = $userModel->getId();

      // Если есть ID  - получаем данные заказа, проверя, что это заказ вошедшего в свой профиль пользователя
      $order = $this->orderRepository->getOrderById((int) $_GET['id']);

      // Проверка, что заказ принадлежит текущему пользователю
      if ( $order->getUserId() !== $userId) {
        header('Location: ' . HOST . 'profile');
        exit();
      }

      // Получаем массив товаров из JSON формата
      $products = $order->getCart();
      
      // Обходим массив с товарами и создаем ассоциативный массив с id => 1
      $ids = array_fill_keys(array_column($products, 'id'), 1);

      // Запрос продуктов и соответствующих им изображений
      $productRepository = new ProductRepository();
      // Пересобирем в новый массив $productsData с ключами - Id товара
      $productsData = $productRepository->getProductsByIds($ids);

      // Создаём ассоциативный массив из cart: [id => amount]
      $amountMap = array_column($products, 'amount', 'id');

      foreach ($productsData as &$product) {
          $productId = $product['id'];
          $product['amount'] = $amountMap[$productId] ?? 0;
      }
      unset($product);

      $this->renderOrder($routeData, $order, $productsData);
  }
}