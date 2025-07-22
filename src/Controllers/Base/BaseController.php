<?php
declare(stricts_types=1);

namespace Vvintage\Controllers\Base;


final class BaseController
{
  public function __construct()
  {

  }

  protected function renderLayout(string $viewPath, array $vars = []): void
  {
    // Превращаем элементы массива в переменные
    extract($vars);

    ob_start();
    include ROOT . 'views/{$viewPath}/{$viewPath}.tpl'; // views/cart/cart.tpl
    $content = ob_get_clean();

    include ROOT . 'views/layout.php';

  }

  
}