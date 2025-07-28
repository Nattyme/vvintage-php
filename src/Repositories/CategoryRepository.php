<?php

declare(strict_types=1);

namespace Vvintage\Repositories;

use RedBeanPHP\R;
use RedBeanPHP\OODBBean;

final class CategoryRepository
{
    public function findById(int $id): ?OODBBean
    {
        $bean = R::findOne('categories', 'id = ?', [$id]);
        return $bean ?: null;
    }

    public function findAll(): array
    {
        return R::findAll('posts', 'ORDER BY id DESC ');
    }

    public function findByIds(array $ids): array
    {
        if (empty($ids)) {
            return [];
        }

        // Подготовим placeholders (?, ?, ?) и массив параметров
        $placeholders = R::genSlots($ids);
        $sql = "id IN ($placeholders) ORDER BY id DESC";

        return R::find('categories', $sql, $ids);
    }

    public function countAll(): int
    {
        return R::count('categories');
    }

    public function save(Category $cat): int
    {
        $bean = R::dispense('categories');

        $bean->title = $cat->title;
        $bean->parent_id = $cat->parent_id;
        $bean->image = $cat->image;

        return (int) R::store($bean);
    }

}
