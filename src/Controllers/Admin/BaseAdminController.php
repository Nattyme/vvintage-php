<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Admin;

use Vvintage\Routing\RouteData;
use Vvintage\Models\User\User;
use Vvintage\Models\Settings\Settings;

use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Locale\LocaleService;
use Vvintage\Services\Session\SessionService;

// Пеервод на другие языки
use Vvintage\Config\LanguageConfig;



abstract class BaseAdminController
{
  protected array $settings;
  protected array $languages;
  protected string $currentLang;
  protected FlashMessage $flash;
  protected RouteData $routeData; 
  protected LocaleService $localeService;
  protected SessionService $sessionService;

  public function __construct(
    LocaleService $localeService, 
    SessionService $sessionService, 
    FlashMessage $flash
  )
  {
      $this->settings = Settings::all(); // Получаем 1 раз массив всех настроек 
      $this->localeService = $localeService;
      $this->currentLang = $this->localeService->getCurrentLang();
      $this->languages = LanguageConfig::getAvailableLanguages();
      $this->localeService = $localeService;
      $this->sessionService = $sessionService;
      $this->flash = $flash;
  }

  protected function isAdmin(): bool
  {
    $userModel = $this->sessionService->getLoggedInUser();

    if (!($userModel instanceof User) || $userModel->getRole() !== 'admin') {
      header("Location: " . HOST . 'login');
      exit;
    }

    return true;
  }


  protected function renderLayout(string $viewPath, array $vars = []): void
  {
    $isAdminLoggedIn = $this->isAdmin();

    if(!$isAdminLoggedIn) header('Location: ' . HOST);

    // Превращаем элементы массива в переменные
    extract( array_merge($vars, [
      'settings' => $this->settings,
      'languages' => $this->languages,
      'flash' => $this->flash
    ]) );


    ob_start();
    include ROOT . "views/admin/{$viewPath}.tpl"; // views/cart/cart.tpl
    $content = ob_get_clean();

    // extract( array_merge($vars, ['settings' => $this->settings]) );
    include ROOT . 'views/admin/layout.php';

  }

  protected function setRouteData(RouteData $routeData): void
  {
      $this->routeData = $routeData;
  }

  // $this->redirect('login');
  protected function redirect(string $pageName, string $param = ''): void 
  {
    $path = $param !== '' ? $pageName . '/' . $param : $pageName;

    header("Location: " . HOST . $path);
    exit;
  }


}