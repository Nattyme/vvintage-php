<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Admin;

abstract class BaseAdminController
{

  protected function renderLayout(string $viewPath, array $vars = []): void
  {
    $isAdminLoggedIn = $this->isAdmin();

    if(!$isAdminLoggedIn) {
      header('Location: ' . HOST);
    }

    // Превращаем элементы массива в переменные
    extract( array_merge($vars, ['settings' => $this->settings]) );

    ob_start();
    include ROOT . "views/admin/{$viewPath}.tpl"; // views/cart/cart.tpl
    $content = ob_get_clean();
    // extract( array_merge($vars, ['settings' => $this->settings]) );
    include ROOT . 'views/admin/layout.php';

  }

}