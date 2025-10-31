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
use Vvintage\Services\Locale\LocaleService;
use Vvintage\Services\Order\OrderService;
use Vvintage\Services\SEO\SeoService;

// use Vvintage\Repositories\Order\OrderRepository;
use Vvintage\Repositories\Product\ProductRepository;
use Vvintage\Models\Order\Order;

use Vvintage\DTO\Order\OrderProfileDetailsDTO;

require_once ROOT . './libs/functions.php';


final class ProfileController extends BaseController
{ 
  private UserService $userService;
  private Breadcrumbs $breadcrumbsService;
  private SeoService $seoService;
  private ProfileValidator $validator;
  private PageService $pageService;
  protected LocaleService $localeService;
  protected OrderService $orderService;

  public function __construct(SeoService $seoService, Breadcrumbs $breadcrumbs)
  {
    parent::__construct(); // Важно!
    $this->userService = new UserService();
    $this->breadcrumbsService = $breadcrumbs;
    $this->seoService = $seoService;
    $this->validator = new ProfileValidator();
    $this->pageService = new PageService();
    $this->localeService = new LocaleService();
    $this->orderService = new OrderService();
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
     
        // $order = $orders = $this->userService->getOrdersByUserId($id);
        $orders = $this->orderService->getProfileOrdersList($id);

        $this->renderProfileFull($this->routeData, $userModel, $orders);
      } else {
        $this->redirect('profile');
      }

    } else {
        $id = $userModel->getId() ?? null;
  
        if (!$id) {
          $this->redirect('login');
        }

        $orders = $this->orderService->getProfileOrdersList($id);
  
        $this->renderProfileFull($this->routeData, $userModel, $orders);
    }


     
  }

  public function edit(RouteData $routeData)
  { 
      $this->setRouteData($routeData);
      $pageModel = $this->pageService->getPageModelBySlug($routeData->uriModule);
   
      $userModel = null;
      $uriGet = $this->routeData->uriGet ?? null;

      if ( $this->isAdmin() ) {
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

      $this->renderProfileEdit(routeData: $routeData, userModel: $userModel, uriGet: $uriGet, address: $address);
  }



  public function order(RouteData $routeData)
  {
      $this->setRouteData($routeData);
       
      // Если ID нет - выходим
      $userModel = $this->getLoggedInUser();
      
      // если гость — редиректим
      if (!$userModel || $userModel instanceof GuestUser) {
          $this->redirect('login');
      }


      $userId = $userModel->getId();
      $orderId = $routeData->uriGetParams[0] ?? null;

      
      if (!$orderId || !$userId) {
          $this->redirect('profile');
      }
 
      $order = $this->orderService->getProfileDetailedOrder((int) $orderId);
   
      // Проверка, что заказ принадлежит текущему пользователю
      if (!$order || $order->user_id !== $userId) {
          $this->redirect('profile');
      }

      $this->renderOrder($order);
  }


  private function renderProfileFull(RouteData $routeData, ?User $userModel, ?array $orders): void
  {
      // Название страницы
      $page = $this->pageService->getPageBySlug($routeData->uriModule);
      $pageModel = $this->pageService->getPageModelBySlug($routeData->uriModule);
      $seo = $this->seoService->getSeoForPage('profile', $pageModel);
  
      $pageClass = "profile-page";
      $pageTitle = $seo->title;

      // Хлебные крошки
      $breadcrumbs = $this->breadcrumbsService->generate($routeData, $pageTitle);

          // Подключение шаблонов страницы
      $this->renderLayout('profile/profile-full', [
            'seo' => $seo,
            'pageTitle' => $pageTitle,
            'routeData' => $routeData,
            'breadcrumbs' => $breadcrumbs,
            'navigation' => $this->pageService->getLocalePagesNavTitles(),
            'pageClass' => $pageClass,
            'userModel' => $userModel,
            'orders' => $orders,
            'flash' => $this->flash,
            'currentLang' =>  $this->pageService->currentLang,
            'languages' => $this->pageService->languages
      ]);
  }

  private function renderProfileEdit (RouteData $routeData, ?User $userModel, $address, int|string|null $uriGet = null): void 
  {  
      // Название страницы
      $slug = $uriGet ? $routeData->uriModule . '/' . $uriGet : $routeData->uriModule;

      // Название страницы
      $page = $this->pageService->getPageBySlug($slug);
      $pageModel = $this->pageService->getPageModelBySlug( $slug );
      $seo = $this->seoService->getSeoForPage('profile-edit', $pageModel);

      $pageClass = "profile-page";
      $pageTitle = $seo->title;

      // Хлебные крошки
      $breadcrumbs = $this->breadcrumbsService->generate($routeData, $pageTitle);

      if (isset($_POST['updateProfile']))  $this->updateUserAndGoToProfile($userModel);

 
      // Подключение шаблонов страницы
      $this->renderLayout('profile/profile-edit', [
            'seo' => $seo,
            'pageTitle' => $pageTitle,
            'routeData' => $routeData,
            'breadcrumbs' => $breadcrumbs,
            'pageClass' => $pageClass,
            'userModel' => $userModel,
            'uriGet' => $uriGet,
            'address' => $address,
            'navigation' => $this->pageService->getLocalePagesNavTitles(),
            'currentLang' =>  $this->pageService->currentLang,
            'languages' => $this->pageService->languages
      ]);
  }

  private function renderOrder (?OrderProfileDetailsDTO $order): void 
  {  
      // Название страницы
      $pageTitle = "Заказ &#8470;" . h($order->id) . "&#160; от &#160;" . $order->formatted_date;
      $pageClass = "profile-page";

      // Хлебные крошки
      $breadcrumbs = $this->breadcrumbsService->generate($this->routeData, $pageTitle);

      // Подключение шаблонов страницы
      $this->renderLayout('profile/profile-order', [
            'pageTitle' => $pageTitle,
            'routeData' => $this->routeData,
            'breadcrumbs' => $breadcrumbs,
            'pageClass' => $pageClass,
            'navigation' => $this->pageService->getLocalePagesNavTitles(),
            'order' => $order,
            'currentLang' =>  $this->pageService->currentLang,
            'languages' => $this->pageService->languages
      ]);

  }


  private  function updateUserAndGoToProfile (User $userModel) {
    
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
     
    }
  }


}