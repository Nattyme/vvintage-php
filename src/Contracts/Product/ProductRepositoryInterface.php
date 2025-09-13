<?php

declare(strict_types=1);

namespace Vvintage\Contracts\Product;

use Vvintage\Models\Product\Product;
use Vvintage\DTO\Product\ProductDTO;
use Vvintage\DTO\Product\ProductInputDTO;
use Vvintage\DTO\Product\ProductFilterDTO;

interface ProductRepositoryInterface
 {
    /** GET */
    public function getProductById(int $id): ?Product;

    public function getProductsByParam(string $sql = '', array $params = []): array;

    public function getAllProducts(array $data = []): array;

    public function getProductsByIds(array $ids): array;

    public function getAllProductsCount(?string $sql = null, array $params = []): int;

    public function getLastProducts(int $count): array;

    public function getFilteredProducts(ProductFilterDTO $filterDto): array;

    /** UPDATE */
    public function updateStatus(int $productId, string $status): bool;

    public function updateProductData(int $productId, ProductInputDTO $dto, array $imagesDto, array $translations = []): bool;

    public function bulkUpdate(array $ids, array $data): void;

    /** SAVE */
    public function saveProduct(ProductInputDTO $dto, array $translations, array $images, array  $processedImages): ?int;

    public function saveProductTranslation(array $translateDto): ?array;

    public function saveProductImages(array $imagesDto): ?array;

}
