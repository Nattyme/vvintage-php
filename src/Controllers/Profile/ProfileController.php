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
use Vvintage\Repositories\UserRepository;
// use Vvintage\Models\Orders\Orders;

require_once ROOT . './libs/functions.php';


final class ProfileController extends BaseController
{ 
  private UserRepository $userRepository;
  private SessionManager $sessionManager;
  private Breadcrumbs $breadcrumbsService;
  private FlashMessage $notes;

  public function __construct(SessionManager $sessionManager, Breadcrumbs $breadcrumbs, FlashMessage $notes)
  {
    parent::__construct(); // Важно!
    $this->userRepository = new UserRepository();
    $this->sessionManager = $sessionManager;
    $this->breadcrumbsService = $breadcrumbs;
    $this->notes = $notes;
  }

  private function renderPage (RouteData $routeData, ?User $userModel): void 
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
            'userModel' => $userModel
      ]);
  }


  public function index(RouteData $routeData)
  {
    $id = isset($_SESSION['logged_user']) ? $_SESSION['logged_user']['id'] : null;

    if($id !== null) {
      $userModel = $this->userRepository->findUserById($id);
    }
// dd($userModel);
    $this->renderPage($routeData, $userModel);
  }

  public function edit(RouteData $routeData)
  {

  }
}