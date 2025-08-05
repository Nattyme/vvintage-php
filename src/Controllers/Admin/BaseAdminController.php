<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Admin;

use Vvintage\Models\Settings\Settings;
use Vvintage\Services\Auth\SessionManager;
use Vvintage\Models\User\User;

// Пеервод на другие языки
use Vvintage\Config\LanguageConfig;


abstract class BaseAdminController
{
  protected array $settings;
  protected array $languages;

  public function __construct()
  {
      $this->settings = Settings::all(); // Получаем 1 раз массив всех настроек 
      $this->languages = LanguageConfig::getAvailableLanguages();
  }

  protected function isAdmin(): bool
  {
    $sessionManager = new SessionManager();
    $userModel = $sessionManager->getLoggedInUser();

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
      'languages' => $this->languages
    ]) );

    ob_start();
    include ROOT . "views/admin/{$viewPath}.tpl"; // views/cart/cart.tpl
    $content = ob_get_clean();

    // extract( array_merge($vars, ['settings' => $this->settings]) );
    include ROOT . 'views/admin/layout.php';

  }

}