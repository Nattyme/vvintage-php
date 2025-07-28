<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Base;

use Vvintage\Models\Settings\Settings;
use Vvintage\Services\Auth\SessionManager;
use Vvintage\Controllers\AdminPanel\AdminPanelController;


abstract class BaseController
{    
  protected array $settings;

  public function __construct()
  {
      $this->settings = Settings::all(); // Получаем 1 раз массив всех настроек 
  }

  protected function renderLayout(string $viewPath, array $vars = []): void
  {
    $isAdminLoggedIn = $this->isAdmin();
    $adminData = [];

    if($isAdminLoggedIn) {
      $panel = new AdminPanelController();
      $adminData = $panel->index();
    }

    // Превращаем элементы массива в переменные
    extract( array_merge($vars, ['settings' => $this->settings, 'adminData' => $adminData]) );

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

    return $userModel && $userModel->getRole() === 'admin';
  }

  
}