<?php

declare(strict_types=1);

namespace Vvintage\Contracts\Brand;

use Vvintage\Models\Brand\Brand;

interface BrandRepositoryInterface
{
    public function getBrandById(int $id): ?Brand;
    public function getAllBrands(): array;
    public function getBrandsByIds(array $ids): array;
    public function saveBrand(Brand $brand): ?int;
    public function getAllBrandsCount(?string $sql = null, array $params = []): int;
    public function getBrandsArray(): array;
}
