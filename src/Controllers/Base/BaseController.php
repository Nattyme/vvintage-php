<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Base;

/** Интерфейсы */
use Vvintage\Routing\RouteData;

use Vvintage\Models\User\User;
use Vvintage\Models\Settings\Settings;
use Vvintage\Contracts\User\UserInterface;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Session\SessionService;
use Vvintage\Services\AdminPanel\AdminPanelService;


abstract class BaseController
{    
  protected array $settings;
  protected RouteData $routeData; 

  public function __construct(
    protected FlashMessage $flash,
    protected SessionService $sessionService
  )
  {
      $this->settings = Settings::all(); 
  }


  public function setRouteData(RouteData $routeData): void
  {
      $this->routeData = $routeData;
  }

  protected function renderLayout(string $viewPath, array $vars = []): void
  {
    $isAdminLoggedIn = $this->isAdmin();

    $routePath = $vars['routeData'] ?? $this->routeData->getUriModule() ?? $_SERVER['REQUEST_URI'];
    $isBlogPage = $this->isBlogPage($routePath);
    $adminData = [];

    if($isAdminLoggedIn) {
      $service = new AdminPanelService();
      $adminData = $service->getCounters();
    }

    // Превращаем элементы массива в переменные
    extract( array_merge($vars, [
      'settings' => $this->settings, 
      'adminData' => $adminData,
      'flash' => $this->flash,
      'isBlogPage' => $isBlogPage
    ]) );

    ob_start();
    include ROOT . "views/{$viewPath}.tpl"; // views/cart/cart.tpl
    $content = ob_get_clean();
    include ROOT . 'views/layout.php';

  }

  protected function renderAuthLayout(string $viewPath, array $vars = []): void
  {
     $isAdminLoggedIn = $this->isAdmin();
     

    if($isAdminLoggedIn) {
      $service = new AdminPanelService();
      $adminData = $service->getCounters();
    }

    $routePath = $this->routeData->getUriModule() ?? $_SERVER['REQUEST_URI'];
    $isBlogPage = $this->isBlogPage($routePath);
  
    // Превращаем элементы массива в переменные
    extract( array_merge($vars, [
      'pageClass' => 'authorization-page',
      'settings' => $this->settings, 
      'adminData' => $adminData ?? [],
      'flash' => $this->flash
    ]) );

    ob_start();
    include ROOT . "views/{$viewPath}.tpl"; // views/cart/cart.tpl
    $content = ob_get_clean();

    include ROOT . "views/_page-parts/_head.tpl";
    include ROOT . "views/login/login-page.tpl";
    include ROOT . "views/_page-parts/_foot.tpl";

  }

  protected function isAdmin(): bool
  {
    $userModel = $this->sessionService->getLoggedInUser();
    
    if( $userModel instanceof User) {
      return $userModel && $userModel->getRole() === 'admin';
    }

    return false;
  }

   protected function isLoggedIn(): bool
   {
      return $this->sessionService->isLoggedIn();
   }

   protected function getLoggedInUser(): ?UserInterface
   {
    return $this->sessionService->getLoggedInUser();
   }

  protected function isBlogPage(): bool 
  {
      return $this->routeData->getUriModule() === 'blog' || $this->routeData->getUriModule() === 'post';
  }

  // TODO: возможно метод удалить и использовать только сессию
  protected function isProfileOwner(int $profileId): bool 
  {
    return  $this->sessionService->isProfileOwner($profileId);
  }

  protected function redirect(string $pageName, string $param = ''): void 
  {
    $path = $param !== '' ? $pageName . '/' . $param : $pageName;

    header("Location: " . HOST . $path);
    exit;
  }

  
}