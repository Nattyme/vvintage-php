<?php

declare(strict_types=1);

namespace Vvintage\Contracts\Brand;

use Vvintage\Models\Brand\Brand;
use Vvintage\DTO\Brand\BrandDTO;

interface BrandRepositoryInterface
{
    public function getBrandById(int $id): ?Brand;
    public function getAllBrands(): array;
    public function getBrandsByIds(array $ids): array;
    public function saveBrand(BrandDTO $brand): ?int;
    public function getAllBrandsCount(?string $sql = null, array $params = []): int;
    public function getBrandsArray(): array;
    public function existsByTitle(string $cleaned): ?int;
}
