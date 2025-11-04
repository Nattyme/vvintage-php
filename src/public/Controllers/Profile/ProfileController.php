<?php
declare(strict_types=1);

namespace Vvintage\public\Controllers\Profile;

use Vvintage\Routing\RouteData;


/** Базовый контроллер страниц*/
use Vvintage\public\Controllers\Base\BaseController;

use Vvintage\Models\User\User;
use Vvintage\Models\User\GuestUser;
use Vvintage\Models\Address\Address;

/** Сервисы */
use Vvintage\Services\Page\Breadcrumbs;
use Vvintage\Services\User\UserService;
use Vvintage\Services\Page\PageService;
use Vvintage\Services\Profile\ProfileService;
use Vvintage\Services\Locale\LocaleService;
use Vvintage\Services\Order\OrderService;
use Vvintage\Services\SEO\SeoService;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Session\SessionService;

use Vvintage\Models\Order\Order;

use Vvintage\DTO\Order\OrderProfileDetailsDTO;

require_once ROOT . './libs/functions.php';


final class ProfileController extends BaseController
{ 
  private UserService $userService;
  private Breadcrumbs $breadcrumbsService;
  protected SeoService $seoService;
  protected PageService $pageService;
  private ProfileService $profileService;
  protected LocaleService $localeService;
  protected OrderService $orderService;
  

  public function __construct( 
    FlashMessage $flash,
    SessionService $sessionService,
    SeoService $seoService, 
    Breadcrumbs $breadcrumbs
  )
  {
    $this->userService = new UserService();
    $this->breadcrumbsService = $breadcrumbs;
    $this->seoService = $seoService;
    $this->pageService = new PageService();
    $this->localeService = new LocaleService();
    $this->orderService = new OrderService();
    $this->profileService = new ProfileService();
    parent::__construct($flash, $sessionService, $this->pageService, $this->seoService); // Важно!
  }


  public function index(RouteData $routeData)
  {
   
    $this->setRouteData($routeData);
    $uriGet = (int) $this->routeData->uriGet ?? null;

    $orders = null;
    $userModel = $this->getLoggedInUser();
    $userId = $userModel->getId();

    // если гость — редиректим
    if ($userModel instanceof GuestUser || !$userModel) $this->redirect('login');


    // Если зашли в свой профиль
    if (!$uriGet && $this->isProfileOwner($userId) || $uriGet && $uriGet === $userId) {
      $profileData = $this->profileService->getFullProfileData($userId);
      $this->renderProfileFull($this->routeData,  $profileData['userModel'], $profileData['orders']);
    }

    //  Если зашли на страницу чужого профиля
    if ( $uriGet && !$this->isProfileOwner($uriGet)) {
      if($this->isLoggedIn() && !$this->isAdmin()) $this->redirect('profile'); // если залогинен - редирект в свой профиль

      // Значит админ
      $profileData = $this->profileService->getFullProfileData($uriGet);
      $this->renderProfileFull($this->routeData, $profileData['userModel'], $profileData['orders']);
    } 
  }



  public function edit(RouteData $routeData)
  { 
      $this->setRouteData($routeData);
    
      $pageModel = $this->pageService->getPageModelBySlug($routeData->uriModule); // страница
   
      $userModel = null;
      $uriGet = (int) (!empty($this->routeData->uriGetParams) ? $this->routeData->uriGetParams[0] : null); // id пользователя

      // Если uriGet нет
      if(!$uriGet && $this->isLoggedIn()) $uriGet = $this->getLoggedInUser()->getId(); // если нет id, но залогинен

      //Полуечаем залогиненного пользователя и его id
      $userModel = $this->getLoggedInUser();
      $userId = $userModel->getId();

      if ($userModel instanceof GuestUser || !$userModel) $this->redirect('login');  // если гость — редиректим
      if (!($this->isProfileOwner($userId) || $this->isAdmin())) $this->redirect('profile'); // не владелец, не админ
  

      // Если зашли в свой профиль - показываем форму
      if ($this->isProfileOwner($uriGet)) {
        $this->renderProfileEdit(routeData: $routeData, userModel: $userModel, uriGet: $uriGet);
      }

      //  Если зашли на страницу чужого профиля
      if ( !$this->isProfileOwner($uriGet)) {
  
        if($this->isLoggedIn() && !$this->isAdmin()) $this->redirect('profile'); // если залогинен - редирект в свой профиль
        if(!$this->isAdmin()) $this->redirect('login');  // Если не залогинен - на страницу логина

        // Значит админ
        $profileData = $this->profileService->getFullProfileData($uriGet); // получаем данные профиля пользователя
      
        // $address ; // потом доработать адрес
        $this->renderProfileEdit(routeData: $routeData, userModel: $profileData['userModel'], uriGet: $uriGet);
      } 

     
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

  private function renderProfileEdit (RouteData $routeData, ?User $userModel, int|string|null $uriGet = null): void 
  {  
      // Название страницы
      $slug = $routeData->uriModule . '/' . $routeData->uriGet;

      // Название страницы
      $page = $this->pageService->getPageBySlug($slug);
      $pageModel = $this->pageService->getPageModelBySlug( $slug );
      $seo = $this->seoService->getSeoForPage('profile-edit', $pageModel);

      $pageClass = "profile-page";
      $pageTitle = $seo->title;

      // Хлебные крошки
      $breadcrumbs = $this->breadcrumbsService->generate($routeData, $pageTitle);

      if (isset($_POST['updateProfile'])) {
        try {
          $result = $this->profileService->updateUserAndGoToProfile($_POST, $_FILES, $userModel);

          $userModel = $this->userService->getUserById($userModel->getId()); // получим модель с обновленными данными
          $this->sessionService->updateUserAvatar($userModel); // обновим изображение в сессии

          $this->flash->pushSuccess('Данные профиля были успешно обновлены.');
          $this->redirect('profile', (string) $userModel->getId() );
        }
        catch (\Exception $error) {
          $this->flash->pushError('error', $error->getMessage());
        }
      }  

      // Подключение шаблонов страницы
      $this->renderLayout('profile/profile-edit', [
            'seo' => $seo,
            'pageTitle' => $pageTitle,
            'routeData' => $routeData,
            'breadcrumbs' => $breadcrumbs,
            'pageClass' => $pageClass,
            'userModel' => $userModel,
            'uriGet' => $uriGet,
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


  // private  function updateUserAndGoToProfile (array $data,User $userModel) {
    


  //     $files = $_FILES['avatar'] ?? [];
  //     // Если ошибок нет - сохраняем
  //     if ( !empty($files['name']) && $files['tmp_name'] !== '') {
  //       $validAvatar = $this->validator->validateEditAvatar($files);
  //       if(!$validAvatar) return;

  //       $avatars = $this->userService->handleAvatar($userModel, $files);
  //       $data = array_merge($data, $avatars);
  //     }

  //     $valid = $this->validator->validateEdit($data);

  //     if(!$valid) return;
  //     $dto = $this->userService->getUserUpdateDto($data);
      
  //     $this->userService->updateUser($dto, $userModel->getId());

  //     $this->redirect('profile', (string) $userModel->getId());
     
  // }


}