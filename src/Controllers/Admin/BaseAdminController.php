<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Admin;

use Vvintage\Routing\RouteData;
use Vvintage\Models\Settings\Settings;
use Vvintage\Services\Session\SessionService;
use Vvintage\Models\User\User;
use Vvintage\Services\Messages\FlashMessage;

// Пеервод на другие языки
// Пеервод на другие языки
use Vvintage\Config\LanguageConfig;
use Vvintage\Services\Locale\LocaleService;


abstract class BaseAdminController
{
  protected RouteData $routeData; 
  protected array $settings;
  protected LocaleService $localeService;
  protected array $languages;
  protected string $currentLang;
  protected FlashMessage $flash;

  public function __construct()
  {
      $this->settings = Settings::all(); // Получаем 1 раз массив всех настроек 
      $this->localeService = new LocaleService();
      $this->currentLang = $this->localeService->getCurrentLang();
      $this->languages = LanguageConfig::getAvailableLanguages();
      $this->flash = new FlashMessage();
  }

  protected function isAdmin(): bool
  {
    $sessionService = new SessionService();
    $userModel = $sessionService->getLoggedInUser();

    if (!($userModel instanceof User) || $userModel->getRole() !== 'admin') {
      header("Location: " . HOST . 'login');
      exit;
    }

    return true;
  }


  protected function renderLayout(string $viewPath, array $vars = []): void
  {
    $isAdminLoggedIn = $this->isAdmin();

    if(!$isAdminLoggedIn) {
      header('Location: ' . HOST);
    }

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