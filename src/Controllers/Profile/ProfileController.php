<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Profile;

use Vvintage\Routing\RouteData;


/** Базовый контроллер страниц*/
use Vvintage\Controllers\Base\BaseController;

use Vvintage\Models\User\User;
use Vvintage\Models\Address\Address;

/** Сервисы */
use Vvintage\Services\Page\Breadcrumbs;
use Vvintage\Services\User\UserService;
use Vvintage\Services\Validation\ProfileValidator;

// use Vvintage\Repositories\Order\OrderRepository;
use Vvintage\Repositories\Product\ProductRepository;
use Vvintage\Models\Order\Order;

require_once ROOT . './libs/functions.php';


final class ProfileController extends BaseController
{ 
  private UserService $userService;
  private Breadcrumbs $breadcrumbsService;
  private ProfileValidator $validator;

  public function __construct(Breadcrumbs $breadcrumbs)
  {
    parent::__construct(); // Важно!
    $this->userService = new UserService($this->languages, $this->currentLang);
    $this->breadcrumbsService = $breadcrumbs;
    $this->validator = new ProfileValidator();
  }


  public function index(RouteData $routeData)
  {
    $orders = null;
    $userModel = null;
    $this->setRouteData($routeData);

    $userModel = $this->getLoggedInUser();
    
    if(!$userModel) {
      header("Location: " . HOST . 'login');
      exit;
    };

    if( empty($this->routeData->uriGet) ) {
   
      $id = $userModel->getId() ?? null;
  
      if (!$id) {
        header("Location: " . HOST . 'login');
        exit;
      }

      $orders = $this->userService->getOrdersByUserId($id);
      $this->renderProfileFull($this->routeData, $userModel, $orders);
    } else {
        $id = (int) $this->routeData->uriGet ?? null;
        
        if(!is_numeric($this->routeData->uriGet) || !$id) {
          header("Location: " . HOST . 'profile');
          exit;
        }

        if ($this->isProfileOwner($id) || $this->isAdmin()) {
          $userModel = $this->userService->getUserByID($id);

          if(!$userModel) {
            header("Location: " . HOST . 'profile');
            exit;
          }
          
          $order = $orders = $this->userService->getOrdersByUserId($id);

          $this->renderProfileFull($this->routeData, $userModel, $orders);
        } else {
          $this->renderProfile($this->routeData, $userModel);
        }

    }
     
  }

  public function edit(RouteData $routeData)
  {
      $this->setRouteData($routeData);

      $loggedUser = $this->getLoggedInUser();
      if (!$loggedUser) {
          header("Location: " . HOST . 'login');
          exit;
      }

      // Определяем ID пользователя, которого хотим редактировать
      $id = $loggedUser->getId(); // по умолчанию редактируем себя
      if ($this->isAdmin() && !empty($this->routeData->uriGet)) {
          $idFromUri = (int)$this->routeData->uriGet;
          if (is_numeric($idFromUri) && $idFromUri > 0) {
              $id = $idFromUri;
          }
      }

      // Получаем пользователя по ID
      $userModel = $this->userService->getUserByID($id);
      if (!$userModel) {
          header("Location: " . HOST . 'profile');
          exit;
      }

      // Проверяем права: владелец профиля или админ
      if ($this->isProfileOwner($id) || $this->isAdmin()) {
          $orders = $this->userService->getOrdersByUserId($id);
          $address = null; // здесь можно добавить $userModel->getAddress()

          $this->renderProfileEdit($routeData, $userModel, $address);
      } else {
          // Нет прав — редирект на свой профиль
          header('Location: ' . HOST . 'profile');
          exit();
      }
  }



  public function order(RouteData $routeData)
  {
       $this->setRouteData($routeData);
       
      // Если ID нет - выходим
      if ( !isset($_GET['id']) || empty($_GET['id'])) {
        header('Location: ' . HOST . 'profile');
        exit();
      }

      $userModel = null;
      $isLoggedUser = $this->isLoggedIn();

      if(!$isLoggedUser) {
        header('Location: ' . HOST . 'login');
      }

      $userModel = $this->getLoggedInUser();
      $userId = $userModel->getId();

      // Если есть ID  - получаем данные заказа, проверя, что это заказ вошедшего в свой профиль пользователя
      $orders = $this->userService->getOrderById((int)$routeData->uriGetParam);
      // Проверка, что заказ принадлежит текущему пользователю
      if ( $order->getUserId() !== $userId) {
        header('Location: ' . HOST . 'profile');
        exit();
      }

      // Получаем массив товаров из JSON формата
      $products = $order->getCart();
      
      // Обходим массив с товарами и создаем ассоциативный массив с id => 1
      $ids = array_fill_keys(array_column($products, 'id'), 1);

      // Пересобирем в новый массив $productsData с ключами - Id товара
      $productsData = $this->userService->getProductsByIds($ids);

      // Создаём ассоциативный массив из cart: [id => amount]
      $amountMap = array_column($products, 'amount', 'id');

      foreach ($productsData as &$product) {
          $productId = $product['id'];
          $product['amount'] = $amountMap[$productId] ?? 0;
      }
      unset($product);

      $this->renderOrder($routeData, $order, $productsData);
  }


  private function renderProfile (RouteData $routeData, ?User $userModel): void 
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
            'orders' => $orders,
            'flash' => $this->flash
      ]);
  }

  private function renderProfileFull(RouteData $routeData, ?User $userModel, ?array $orders): void
  {
      // Название страницы
      $pageTitle = 'Профиль пользователя';
      $pageClass = "profile-page";

      // Хлебные крошки
      $breadcrumbs = $this->breadcrumbsService->generate($routeData, $pageTitle);

          // Подключение шаблонов страницы
      $this->renderLayout('profile/profile-full', [
            'pageTitle' => $pageTitle,
            'routeData' => $routeData,
            'breadcrumbs' => $breadcrumbs,
            'pageClass' => $pageClass,
            'userModel' => $userModel,
            'orders' => $orders,
            'flash' => $this->flash
      ]);
  }

  private function renderProfileEdit (RouteData $routeData, ?User $userModel,  $address): void 
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
            'userModel' => $userModel,
            'address' => $address,
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
}