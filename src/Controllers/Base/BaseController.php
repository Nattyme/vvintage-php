<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Base;

use Vvintage\Models\Settings\Settings;


class BaseController
{    
  protected array $settings;

  public function __construct()
  {
      $this->settings = Settings::all(); // Получаем 1 раз массив всех настроек 
  }

  protected function renderLayout(string $viewPath, array $vars = []): void
  {
    // Превращаем элементы массива в переменные
    extract( array_merge($vars, ['settings' => $this->settings]) );

    ob_start();
    include ROOT . "views/{$viewPath}.tpl"; // views/cart/cart.tpl
    $content = ob_get_clean();

    include ROOT . 'views/layout.php';

  }

  
}