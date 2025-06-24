<?php 
declare(strict_types=1);

namespace Vvintage\Models\Shop;

use RedBeanPHP\R;
use Vvintage\Repositories\ProductRepository;
use Vvintage\Database\Database;

require_once ROOT . "./libs/functions.php";

final class Catalog 
{
  public static function getAll($pagination): array {
    $products = ProductRepository::findAll($pagination);
    return $products;
  }

  public static function getTotalProductsCount(): int
  {
    return R::count('products');
  }
}