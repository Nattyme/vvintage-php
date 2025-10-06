<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Profile;

use Vvintage\Routing\RouteData;


/** Базовый контроллер страниц*/
use Vvintage\Controllers\Base\BaseController;

use Vvintage\Models\User\User;
use Vvintage\Models\User\GuestUser;
use Vvintage\Models\Address\Address;

/** Сервисы */
use Vvintage\Services\Page\Breadcrumbs;
use Vvintage\Services\User\UserService;
use Vvintage\Services\Validation\ProfileValidator;
use Vvintage\Services\Page\PageService;

// use Vvintage\Repositories\Order\OrderRepository;
use Vvintage\Repositories\Product\ProductRepository;
use Vvintage\Models\Order\Order;

require_once ROOT . './libs/functions.php';


final class ProfileController extends BaseController
{ 
  private UserService $userService;
  private Breadcrumbs $breadcrumbsService;
  private ProfileValidator $validator;
  private PageService $pageService;

  public function __construct(Breadcrumbs $breadcrumbs)
  {
    parent::__construct(); // Важно!
    $this->userService = new UserService();
    $this->breadcrumbsService = $breadcrumbs;
    $this->validator = new ProfileValidator();
    $this->pageService = new PageService();
  }


  public function index(RouteData $routeData)
  {
   
    $orders = null;
    $this->setRouteData($routeData);
    $uriGet = $this->routeData->uriGet ?? null;

    $userModel = $this->getLoggedInUser();

    // если гость — редиректим
    if ($userModel instanceof GuestUser || !$userModel) {
        $this->redirect('login');
    }


    if( $uriGet ) {
      $id = (int) $uriGet ?? null;
      
      if(!is_numeric($uriGet) || !$id) {
        $this->redirect('profile');
      }

      if ($this->isProfileOwner($id) || $this->isAdmin()) {
        $userModel = $this->userService->getUserByID($id);

        if(!$userModel) {
          $this->redirect('profile');
        }
        
        $order = $orders = $this->userService->getOrdersByUserId($id);

        $this->renderProfileFull($this->routeData, $userModel, $orders);
      } else {
        $this->redirect('profile');
      }

    } else {
        $id = $userModel->getId() ?? null;
  
        if (!$id) {
          $this->redirect('login');
        }

        $orders = $this->userService->getOrdersByUserId($id);
        $this->renderProfileFull($this->routeData, $userModel, $orders);
    }


     
  }

  public function edit(RouteData $routeData)
  {
      $this->setRouteData($routeData);

      $userModel = null;

      if ( $this->isAdmin() ) {
        $uriGet = $this->routeData->uriGet ?? null;
 
        // проверка на доп параметр 
        if (!empty( $uriGet ) ) {
           
          $idFromUri = (int) $uriGet;
           
          if (is_numeric($idFromUri) && $idFromUri > 0) {
            
              $userModel = $this->userService->getUserByID($idFromUri);
          }
        } else {
          $userModel = $this->getLoggedInUser();
        }
      }

      if (!$userModel) {
        $userModel = $this->getLoggedInUser();
      }

    
      // если гость — редиректим
      if ($userModel instanceof GuestUser || !$userModel) {
          $this->redirect('login');
      }

      

      // Проверяем права: владелец профиля или админ
      if (!($this->isProfileOwner($userModel->getId()) || $this->isAdmin())) {
           $this->redirect('profile');
      }

      $orders = $this->userService->getOrdersByUserId($userModel->getId());
      $address = null; // здесь можно добавить $userModel->getAddress()


      if (isset($_POST['updateProfile'])) {
        
        $this->updateUserAndGoToProfile($userModel);
      }


      $this->renderProfileEdit($routeData, $userModel, $uriGet, $address);

  }



  public function order(RouteData $routeData)
  {
      $this->setRouteData($routeData);
       
      // Если ID нет - выходим
      $userModel = $this->getLoggedInUser();

      // если гость — редиректим
      if ($userModel instanceof GuestUser || !$userModel) {
          $this->redirect('login');
      }

      $userModel = $this->getLoggedInUser();
      $userId = $userModel->getId();

      // Если есть ID  - получаем данные заказа, проверя, что это заказ вошедшего в свой профиль пользователя

      $order = $this->userService->getOrderById((int) $routeData->uriGet);
   
      // Проверка, что заказ принадлежит текущему пользователю
      if ( $order->getUserId() !== $userId) {
        $this->redirect('profile');
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
          $amount = $amountMap[$product->id] ?? 0;
          $product->setAmount($amount);
      }
      unset($product);

      $this->renderOrder($routeData, $order, $productsData);
  }


  // private function renderProfile (RouteData $routeData, ?User $userModel): void 
  // {  
  //     // Название страницы
  //     $pageTitle = 'Профиль пользователя';
  //     $pageClass = "profile-page";

  //     // Хлебные крошки
  //     $breadcrumbs = $this->breadcrumbsService->generate($routeData, $pageTitle);

  //     // Подключение шаблонов страницы
  //     $this->renderLayout('profile/profile', [
  //           'pageTitle' => $pageTitle,
  //           'routeData' => $routeData,
  //           'breadcrumbs' => $breadcrumbs,
  //           'pageClass' => $pageClass,
  //           'userModel' => $userModel,
  //           'flash' => $this->flash
  //     ]);
  // }

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
            'navigation' => $this->pageService->getLocalePagesNavTitles(),
            'pageClass' => $pageClass,
            'userModel' => $userModel,
            'orders' => $orders,
            'flash' => $this->flash
      ]);
  }

  private function renderProfileEdit (RouteData $routeData, ?User $userModel, $uriGet, $address): void 
  {  
      // Название страницы
      $pageTitle = 'Редактирование профиля пользователя';
      $pageClass = "profile-page";


      // Хлебные крошки
      $breadcrumbs = $this->breadcrumbsService->generate($routeData, $pageTitle);
 
phpinfo();
      // dd($userModel);
      // if (isset($_POST['updateProfile'])) {

      //   $this->updateUserAndGoToProfile($userModel);
      // }

      // Подключение шаблонов страницы
      $this->renderLayout('profile/profile-edit', [
            'pageTitle' => $pageTitle,
            'routeData' => $routeData,
            'breadcrumbs' => $breadcrumbs,
            'pageClass' => $pageClass,
            'userModel' => $userModel,
            'uriGet' => $uriGet,
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


  private  function updateUserAndGoToProfile (User $userModel) {
    // dd($userModel);
    if ( isset($_POST['updateProfile'])) {
      // Принимаем данные
      $data = $_POST;

      $files = $_FILES['avatar'] ?? [];
      // Если ошибок нет - сохраняем
      if ( !empty($files['name']) && $files['tmp_name'] !== '') {
        $validAvatar = $this->validator->validateEditAvatar($files);
        if(!$validAvatar) return;
        $avatars = $this->userService->handleAvatar($userModel, $files);
        $data = array_merge($data, $avatars);
      }

      $valid = $this->validator->validateEdit($data);

      if(!$valid) return;
      $dto = $this->userService->getUserUpdateDto($data);
      
      $this->userService->updateUser($dto, $userModel->getId());

      $this->redirect('profile', (string)$userModel->getId());
     
      

    

      // $updatedData = $this->userService->handleFormData($userModel, $data);

      // Удаление аватарки
      // if ( isset($_POST['delete-avatar']) && $_POST['delete-avatar'] == 'on') {
      //   $avatarFolderLocation = ROOT . 'usercontent/avatars/';
        
      //   // Если есть старое изображение - удаляем 
      //   if (file_exists($avatarFolderLocation . $user->avatar) && !empty($user->avatar)) {
      //     unlink($avatarFolderLocation . $user->avatar);
      //   }

      //   if (file_exists($avatarFolderLocation . $user->avatarSmall) && !empty($user->avatarSmall)) {
      //     unlink($avatarFolderLocation . $user->avatarSmall);
      //   }

      //   // Удалить записи файла в БД
      //   $user->avatar = '';
      //   $user->avatarSmall = '';
      // }
    
      // R::store($user);

      // if ($user->id ===  $_SESSION['logged_user']['id']) {
      //   $_SESSION['logged_user'] = $user;
      // }
      
      // $this->redirect('profile', (string) $userModel->getId());
    
    }
  }

  private function redirect(string $pageName, string $param = ''): void 
  {
    $path = $param !== '' ? $pageName . '/' . $param : $pageName;

    header("Location: " . HOST . $path);
    exit;
  }
}