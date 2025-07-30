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

        if (!$bean || !$bean->id) {
            return null;
        }

        return $this->mapBeanToCategory($bean);
    }

    public function findAll(): array
    {
        $beans = R::findAll('categories', 'ORDER BY id DESC');
        return array_map([$this, 'mapBeanToCategory'], $beans);
    }

    public function findByIds(array $ids): array
    {
        if (empty($ids)) {
            return [];
        }

        $placeholders = R::genSlots($ids);
        $sql = "id IN ($placeholders) ORDER BY id DESC";

        $beans = R::find('categories', $sql, $ids);
        return array_map([$this, 'mapBeanToCategory'], $beans);
    }

    public function getMainCats(): array
    {
        return $this->findCatsByParentId();
    }

    public function getSubCats(): array
    {
        $beans = R::findAll('categories', 'parent_id IS NOT NULL');
        return array_map([$this, 'mapBeanToCategory'], $beans);
    }

    public function findCatsByParentId(?int $parentId = null): array
    {
        if ($parentId === null) {
            $beans = R::findAll('categories', 'parent_id IS NULL');
        } else {
            $beans = R::findAll('categories', 'parent_id = ?', [$parentId]);
        }

        return array_map([$this, 'mapBeanToCategory'], $beans);
    }

    public function countAll(): int
    {
        return R::count('categories');
    }

    public function save(Category $cat): int
    {
        $bean = $cat->getId() ? R::load('categories', $cat->getId()) : R::dispense('categories');

        $bean->title = $cat->getTitle(); // по умолчанию ru
        $bean->parent_id = $cat->getParentId();
        $bean->image = $cat->getImage();
        $bean->translations = json_encode([
            'ru' => [
                'title' => $cat->getTitle('ru'),
            ],
            'en' => [
                'title' => $cat->getTitle('en'),
            ],
        ]);
        $bean->seo_title = $cat->getSeoTitle();
        $bean->seo_description = $cat->getSeoDescription();

        return (int) R::store($bean);
    }

    /**
     * Приватный вспомогательный метод:
     * Преобразует OODBBean в модель Category
     */
    private function mapBeanToCategory(OODBBean $bean): Category
    {
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
}
