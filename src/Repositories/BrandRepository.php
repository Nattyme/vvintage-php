<?php

declare(strict_types=1);

namespace Vvintage\Repositories;

use Vvintage\Models\Brand\Brand;

use RedBeanPHP\R;
use RedBeanPHP\OODBBean;

final class BrandRepository
{
    public function findById(int $id): ?OODBBean
    {
        $bean = R::findOne('brands', 'id = ?', [$id]);
        return $bean ?: null;
    }

    public function findAll(): array
    {
        return R::findAll('brands', 'ORDER BY id DESC ');
    }

    public function findByIds(array $ids): array
    {
        if (empty($ids)) {
            return [];
        }

        // Подготовим placeholders (?, ?, ?) и массив параметров
        $placeholders = R::genSlots($ids);
        $sql = "id IN ($placeholders) ORDER BY id DESC";

        return R::find('brands', $sql, $ids);
    }

    public function countAll(): int
    {
        return R::count('brands');
    }

    public function save(Brand $brand): int
    {
        $bean = R::dispense('brands');

        $bean->title = $brand->title;

        return (int) R::store($bean);
    }

}
