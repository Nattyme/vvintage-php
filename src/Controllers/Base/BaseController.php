<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Base;

/** Интерфейсы */
use Vvintage\Routing\RouteData;
use Vvintage\Models\Settings\Settings;
use Vvintage\Services\Session\SessionService;
use Vvintage\Contracts\User\UserInterface;
use Vvintage\Models\User\User;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\AdminPanel\AdminPanelService;


abstract class BaseController
{    
  protected array $settings;
  protected RouteData $routeData; 
  protected Translator $translator;
  protected FlashMessage $flash;
  protected SessionService $sessionService;

  public function __construct()
  {
      $this->settings = Settings::all(); 
      $this->flash = new FlashMessage();
      $this->sessionService = new SessionService();
  }


  public function setRouteData(RouteData $routeData): void
  {
      $this->routeData = $routeData;
  }

  public function getTranslator(): Translator
  {
      return $this->translator;
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

  protected function isBlogPage(RouteData $routePath): bool 
  {
      if (!$routePath) return false;

      return $this->routeData->getUriModule() === 'blog' || $this->routeData->getUriModule() === 'post';
  }

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