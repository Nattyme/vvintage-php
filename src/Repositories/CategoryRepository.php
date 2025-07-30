<?php

declare(strict_types=1);

namespace Vvintage\Repositories;

use Vvintage\Models\Category\Category;

use RedBeanPHP\R;
use RedBeanPHP\OODBBean;

final class CategoryRepository
{
    public function findById(int $id): ?Category
    {
        $bean = R::findOne('categories', 'id = ?', [$id]);

        if (!$bean->id) {
            return null;
        }

        return Category::fromArray([
            'id' => (int) $bean->id,
            'title' => (string) $bean->title,
            'parent_id' => (int) $bean->parent_id,
            'image' => (string) $bean->image,
            'translations' => json_decode($bean->translations, true) ?? [],
            'seo_title' => $bean->seo_title ?? '',
            'seo_description' => $bean->seo_description ?? '',
        ]);
    }

    public function findAll(): array
    {
        return R::findAll('categories', 'ORDER BY id DESC ');
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

    public function getMainCats (): array
    {
      return $this->findCatsByParentId();
    }

    public function getSubCats(): array
    {
      return R::findAll('categories', 'parent_id IS NOT NULL');
    }

    public function findCatsByParentId (?int $parentId = null): array
    {
      if ($parentId === null) {
        return R::findAll('categories', 'parent_id IS NULL');
      }

      return R::findAll('categories', 'parent_id = ?', [$parentId]);
    }

    public function countAll(): int
    {
        return R::count('categories');
    }

    public function save(Category $cat): int
    {
        $bean = $cat->id ? R::load('categories', $cat->id) : R::dispense('categories');

        $bean->title = $cat->title;
        $bean->parent_id = $cat->parent_id;
        $bean->image = $cat->image;

        return (int) R::store($bean);
    }



}
