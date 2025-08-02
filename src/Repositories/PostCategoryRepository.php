<?php
declare(strict_types=1);

namespace Vvintage\Repositories;

use RedBeanPHP\R;
use RedBeanPHP\OODBBean;

/** Модель */
use Vvintage\Models\PostCategory\PostCategory;

/** DTO */
use Vvintage\DTO\PostCategory\PostCategoryDTO;

final class PostCategoryRepository
{
    public function findById(int $id): ?PostCategory
    {
        $bean = R::findOne('posts_categories', 'id = ?', [$id]);

        if (!$bean || !$bean->id) {
            return null;
        }

        return $this->mapBeanToCategory($bean);
    }

    public function findAll(): array
    {
        $beans = R::findAll('posts_categories', 'ORDER BY id DESC');
        return array_map([$this, 'mapBeanToCategory'], $beans);
    }

    public function findByIds(array $ids): array
    {
        if (empty($ids)) {
            return [];
        }

        $placeholders = R::genSlots($ids);
        $sql = "id IN ($placeholders) ORDER BY id DESC";

        $beans = R::find('posts_categories', $sql, $ids);
        return array_map([$this, 'mapBeanToCategory'], $beans);
    }

    public function getMainCats(): array
    {
        return $this->findCatsByParentId();
    }

    public function getSubCats(): array
    {
        $beans = R::findAll('posts_categories', 'parent_id IS NOT NULL');
        return array_map([$this, 'mapBeanToCategory'], $beans);
    }

    public function findCatsByParentId(?int $parentId = null): array
    {
        if ($parentId === null) {
            $beans = R::findAll('posts_categories', 'parent_id IS NULL');
        } else {
            $beans = R::findAll('posts_categories', 'parent_id = ?', [$parentId]);
        }

        return array_map([$this, 'mapBeanToCategory'], $beans);
    }

    public function countAll(): int
    {
        return R::count('posts_categories');
    }

    public function save(Category $cat): int
    {
        $bean = $cat->getId() ? R::load('posts_categories', $cat->getId()) : R::dispense('posts_categories');

        $bean->title = $cat->getTitle(); // по умолчанию ru
        $bean->parent_id = $cat->getParentId();
        $bean->image = $cat->getImage();
        $bean->seo_title = $cat->getSeoTitle();
        $bean->seo_description = $cat->getSeoDescription();

        $id = (int) R::store($bean);

        // Сохраняем переводы в отдельную таблицу
        R::exec('DELETE FROM categories_translation WHERE category_id = ?', [$id]);
        foreach ($cat->getAllTranslations() as $locale => $translation) {
            $transBean = R::dispense('categories_translation');
            $transBean->category_id = $id;
            $transBean->locale = $locale;
            $transBean->title = $translation['title'] ?? '';
            $transBean->description = $translation['description'] ?? '';
            $transBean->meta_title = $translation['meta_title'] ?? '';
            $transBean->meta_description = $translation['meta_description'] ?? '';
            R::store($transBean);
        }

        return $id;
    }

    /**
     * Загружает переводы из categories_translation
     */
    private function loadTranslations(int $categoryId): array
    {
        $rows = R::getAll(
            'SELECT locale, title, description, meta_title, meta_description FROM categories_translation WHERE category_id = ?',
            [$categoryId]
        );

        $translations = [];
        foreach ($rows as $row) {
            $translations[$row['locale']] = [
                'title' => $row['title'],
                'description' => $row['description'],
                'meta_title' => $row['meta_title'],
                'meta_description' => $row['meta_description'],
            ];
        }

        return $translations;
    }

    private function mapBeanToCategory(OODBBean $bean): Category
    {
        $translations = $this->loadTranslations((int) $bean->id);

        $dto = new CategoryDTO([
            'id' => (int) $bean->id,
            'title' => (string) $bean->title,
            'parent_id' => (int) $bean->parent_id,
            'image' => (string) $bean->image,
            'translations' => $translations,
            'seo_title' => $bean->seo_title ?? '',
            'seo_description' => $bean->seo_description ?? '',
        ]);

        return Category::fromDTO($dto);
    }
}
