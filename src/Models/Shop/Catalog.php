<?php

declare(strict_types=1);

namespace Vvintage\Models\Shop;

use Vvintage\Repositories\Product\ProductRepository;
use Vvintage\Database\Database;

require_once ROOT . "./libs/functions.php";

final class Catalog
{
    public static function getAll($pagination): array
    {
        $productRepository = new ProductRepository();
        $products = $productRepository->getAllProducts($pagination);
        return $products;
    }

}
