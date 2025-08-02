<?php

declare(strict_types=1);

namespace Vvintage\Contracts\Product;

use Vvintage\Models\Product\Product;

interface ProductRepositoryInterface
 {
    public function getProductById(int $id): ?Product;

    public function findAll(array $pagination = []): array;

    public function findProductsByIds(array $ids): array;

    public function uniteProductRawData(?int $productId = null): array;

    public function loadTranslations(int $productId): array;

    public function createCategoryDTOFromArray(array $row): CategoryDTO;

    public function createBrandDTOFromArray(array $row): BrandDTO;

    public function fetchImageDTOs(array $row): array;

    public function fetchProductWithJoins(array $row): Product;
}
