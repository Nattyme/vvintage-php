<?php

declare(strict_types=1);

namespace Vvintage\Contracts\Product;

use Vvintage\Models\Shop\Product;

interface ProductRepositoryInterface
 {
    public function getProductById(int $id): ?Product;
    public function getAllProducts(array $pagination = []): array;
    public function getProductsByIds(array $ids): array;
    public function getAllProductsCount(?string $sql = null, array $params = []): int;
}
