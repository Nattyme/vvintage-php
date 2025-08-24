<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Base;

// use Vvintage\Routing\Router;
use Vvintage\Routing\RouteData;
use Vvintage\Models\Settings\Settings;
use Vvintage\Services\Auth\SessionManager;
use Vvintage\Models\User\User;
use Vvintage\Controllers\AdminPanel\AdminPanelController;
use Vvintage\Services\Messages\FlashMessage;

// Пеервод на другие языки
use Vvintage\Config\LanguageConfig;
use Vvintage\Services\Translator\Translator;


abstract class BaseController
{    
  protected array $settings;
  protected array $languages;
  protected string $currentLang;
  protected RouteData $routeData; 
  protected Translator $translator;
  protected FlashMessage $flash;

  public function __construct()
  {
      $this->settings = Settings::all(); 
      $this->translator = setTranslator(); // берём уже установленный переводчик
      $this->languages = LanguageConfig::getAvailableLanguages();
      $this->currentLang = LanguageConfig::getCurrentLocale();
      $this->flash = new FlashMessage();
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
      $panel = new AdminPanelController();
      $adminData = $panel->index();
    }

    // Превращаем элементы массива в переменные
    extract( array_merge($vars, [
      'settings' => $this->settings, 
      'adminData' => $adminData,
      'languages' => $this->languages,
      'currentLang' => $this->currentLang,
      'flash' => $this->flash,
      'isBlogPage' => $isBlogPage
    ]) );

    ob_start();
    include ROOT . "views/{$viewPath}.tpl"; // views/cart/cart.tpl
    $content = ob_get_clean();
    // extract( array_merge($vars, ['settings' => $this->settings]) );
    include ROOT . 'views/layout.php';

  }

  protected function isAdmin(): bool
  {
    $sessionManager = new SessionManager();
    $userModel = $sessionManager->getLoggedInUser();
    
    if( $userModel instanceof User) {
      return $userModel && $userModel->getRole() === 'admin';
    }

    return false;
  }

  protected function isBlogPage(RouteData $routePath): bool 
  {
      if (!$routePath) return false;

      return $this->routeData->getUriModule() === 'blog';
  }

  
}