<?php

declare(strict_types=1);

namespace Vvintage\Repositories\Category;


use RedBeanPHP\R;
use RedBeanPHP\OODBBean;

/** Контракты */
use Vvintage\Contracts\Category\CategoryRepositoryInterface;

/** Абстрактный репозиторий */
use Vvintage\Repositories\AbstractRepository;

use Vvintage\Models\Category\Category;
use Vvintage\DTO\Category\CategoryDTO;


final class CategoryRepository extends AbstractRepository implements CategoryRepositoryInterface
{
    public function getCategoryById(int $id): ?Category
    {
        $bean = $this->findById('categories', $id);

        if (!$bean || !$bean->id) {
            return null;
        }

        return $this->mapBeanToCategory($bean);
    }

    public function getAllCategories(): array
    {
        $beans = $this->findAll('categories');

        return array_map([$this, 'mapBeanToCategory'], $beans);
    }

    public function getCategoriesByIds(array $ids): array
    {
        $beans = $this->findByIds('categories', $ids);

        return array_map([$this, 'mapBeanToCategory'], $beans);
    }

    public function getMainCats(): array
    {
        return $this->findCatsByParentId();
    }

    public function getSubCats(): array
    {
        $beans = $this->findAll('categories', 'parent_id IS NOT NULL');
        return array_map([$this, 'mapBeanToCategory'], $beans);
    }

    public function findCatsByParentId(?int $parentId = null): array
    {
        if ($parentId === null) {
            $beans = $this->findAll('categories', 'parent_id IS NULL');
        } else {
            $beans = $this->findAll('categories', 'parent_id = ?', [$parentId]);
        }

        return array_map([$this, 'mapBeanToCategory'], $beans);
    }

    public function saveCategory(Category $cat): int
    {
        $bean = $cat->getId() ? $this->loadBean('categories', $cat->getId()) : $this->createBean('categories');

        $bean->title = $cat->getTitle(); // по умолчанию ru
        $bean->parent_id = $cat->getParentId();
        $bean->image = $cat->getImage();
        $bean->seo_title = $cat->getSeoTitle();
        $bean->seo_description = $cat->getSeoDescription();

        $id = (int) $this->saveBean($bean);

        // Сохраняем переводы в отдельную таблицу
        R::exec('DELETE FROM categories_translation WHERE category_id = ?', [$id]);
        foreach ($cat->getAllTranslations() as $locale => $translation) {
            $transBean = $this->createBean('categories_translation');
            $transBean->category_id = $id;
            $transBean->locale = $locale;
            $transBean->title = $translation['title'] ?? '';
            $transBean->description = $translation['description'] ?? '';
            $transBean->meta_title = $translation['meta_title'] ?? '';
            $transBean->meta_description = $translation['meta_description'] ?? '';
            $this->saveBean($transBean);
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
            'translations' => $translations
        ]);

        return Category::fromDTO($dto);
    }

    public function getParentCategory(Category $category): ?Category
    {
      $parentId = $category->getParentId();

      if(!$parentId) {
        return null;
      }

      return $this->getCategoryById($parentId);
    }

    public function getCategoryWithChildren(int $id): array
    {
        if ($id <= 0) {
            return [];
        }

        $parentBean = R::findOne('categories', 'id = ?', [$id]);

        if (!$parentBean) {
            return [];
        }

        $childrenBeans = $this->findAll('categories', 'parent_id = ?', [$id]);
        // $childrenBeans = R::findAll('categories', 'parent_id = ?', [$id]);

        $result = [$this->mapBeanToCategory($parentBean)];
        foreach ($childrenBeans as $childBean) {
            $result[] = $this->mapBeanToCategory($childBean);
        }

        return $result;
    }

    public function hasChildren(int $id): bool
    {
        if ($id <= 0) {
            return false;
        }

        return $this->countAll('categories', 'parent_id = ?', [$id]) > 0;
    }

    public function getAllCategoriesCount(?string $sql = null, array $params = []): int
    {
      return $this->countAll('categories', $sql, $params);
    }

}
