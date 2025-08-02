<?php

declare(strict_types=1);

namespace Vvintage\Repositories\Contracts;

use Vvintage\Models\Brand\Brand;

interface BrandRepositoryInterface
{
    public function getBrandById(int $id): ?Brand;

    public function getBrands(): array;

    public function getBrandsByIds(array $ids): array;

    public function countAll(): int;

    public function saveBrand(Brand $brand): int;
}
