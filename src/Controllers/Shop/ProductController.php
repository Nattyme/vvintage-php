<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Shop;

use Vvintage\Models\Shop\Product;
use Vvintage\Models\Settings\Settings;
use Vvintage\Routing\RouteData;

final class ProductController
{
  public static function showProduct(RouteData $data): void 
  {
      // Получаем массив всех настроек
      $settings = Settings::all();

      $id = (int) $data->get; // получаем id товара из URL
      $product = Product::findById($id);

      if (!$product) {
        http_response_code(404);
        echo 'Товар не найден';
        return;
      }

      // Передаем данные в view
      require ROOT . 'views/_page-parts/_head.tpl';
      require ROOT . 'views/_parts/_header.tpl';
      require ROOT . 'views/shop/product.tpl';
      require ROOT . 'views/_parts/_footer.tpl';
      require ROOT . 'views/_page-parts/_foot.tpl';
  }
}

