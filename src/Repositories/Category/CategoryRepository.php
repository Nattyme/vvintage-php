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
    private const TABLE_CATEGORIES = 'categories';
    private const TABLE_CATEGORIES_TRANSLATION = 'categories_translation';
    private string $currentLang;
    private const DEFAULT_LANG = 'ru';

    public function __construct(string $currentLang)
    {
       $this->currentLang = $currentLang;
    }

    /**
     * Загружает переводы из categories_translation
     */
    private function loadTranslations(int $categoryId): array
    {
        $rows = R::getAll(
            'SELECT locale, title, description, meta_title, meta_description FROM ' . self::TABLE_CATEGORIES_TRANSLATION .' WHERE category_id = ?',
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

        $translatedData = $translations[$this->currentLang] ?? $translations[self::DEFAULT_LANG] ?? [
            'title' => '',
            'description' => '',
            'meta_title' => '',
            'meta_description' => ''
        ];


        $dto = new CategoryDTO([
            'id' => (int) $bean->id,
            'title' => (string) $bean->title,
            'parent_id' => (int) $bean->parent_id,
            'image' => (string) $bean->image,
            'translations' => $translations
        ]);

        return Category::fromDTO($dto);
    }


    public function getCategoryById(int $id): ?Category
    {
        $bean = $this->findById(self::TABLE_CATEGORIES, $id);

        if (!$bean || !$bean->id) {
            return null;
        }

        return $this->mapBeanToCategory($bean);
    }

    // public function getAllCategories(): array
    // {
    //     $beans = $this->findAll(self::TABLE_CATEGORIES);

    //     return array_map([$this, 'mapBeanToCategory'], $beans);
    // }

    // private function getAllCategoriesTranslated(array $params): array 
    // {
    //   $sql = '
    //       SELECT c.id, c.parent_id, c.image,
    //         ct.title, ct.description, ct.meta_title, ct.meta_description
    //       FROM categories c
    //       LEFT JOIN categories_translation ct
    //         ON c.id = ct.category_id AND ct.locale = ?
    //   ';

    //   $beans = $this->findAll(self::TABLE_CATEGORIES, $sql, $params);

    //    return array_map([$this, 'mapBeanToCategory'], $beans);
    // }

    public function getAllCategories(): array
    {
        $beans = $this->findAll(self::TABLE_CATEGORIES);
        return array_map([$this, 'mapBeanToCategory'], $beans);
    }

    public function getCategoriesByIds(array $ids): array
    {
        $beans = $this->findByIds(self::TABLE_CATEGORIES, $ids);

        return array_map([$this, 'mapBeanToCategory'], $beans);
    }

    public function getMainCats(): array
    {
        return $this->findCatsByParentId();
    }

    public function getSubCats(): array
    {
        $beans = $this->findAll(self::TABLE_CATEGORIES, 'parent_id IS NOT NULL');
        return array_map([$this, 'mapBeanToCategory'], $beans);
    }

    public function findCatsByParentId(?int $parentId = null): array
    {
        if ($parentId === null) {
            $beans = $this->findAll(self::TABLE_CATEGORIES, 'parent_id IS NULL');
        } else {
            $beans = $this->findAll(self::TABLE_CATEGORIES, 'parent_id = ?', [$parentId]);
        }

        return array_map([$this, 'mapBeanToCategory'], $beans);
    }

    public function saveCategory(Category $cat): int
    {
        $bean = $cat->getId() ? $this->loadBean(self::TABLE_CATEGORIES, $cat->getId()) : $this->createBean(self::TABLE_CATEGORIES);

        $bean->title = $cat->getTitle(); // по умолчанию ru
        $bean->parent_id = $cat->getParentId();
        $bean->image = $cat->getImage();
        $bean->seo_title = $cat->getSeoTitle();
        $bean->seo_description = $cat->getSeoDescription();

        $id = (int) $this->saveBean($bean);

        // Сохраняем переводы в отдельную таблицу
        R::exec('DELETE FROM ' . self::TABLE_CATEGORIES_TRANSLATION .' WHERE category_id = ?', [$id]);
        foreach ($cat->getAllTranslations() as $locale => $translation) {
            $transBean = $this->createBean(self::TABLE_CATEGORIES_TRANSLATION);
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

    

   
    private function mapBeanToArray(OODBBean $bean): array
    {
      $translations = $this->loadTranslations((int) $bean->id);

      return [
          'id' => (int) $bean->id,
          'title' => (string) $bean->title,
          'parent_id' => (int) $bean->parent_id,
          'image' => (string) $bean->image,
          'translations' => $translations
      ];
    }

    // Для api
    public function getMainCategoriesArray(): array
    {
        // Достаём все категории, у которых parent_id = NULL
        $beans = $this->findAll(self::TABLE_CATEGORIES, 'parent_id IS NULL');

        // Сбрасываем ключи и преобразуем в массивы
        return array_values(array_map([$this, 'mapBeanToArray'], $beans));
    }

    public function getSubCategoriesArray(?int $parent_id = null): array
    {

        if ($parent_id !== null) {
            $beans = $this->findAll(self::TABLE_CATEGORIES, 'parent_id = ?', [$parent_id]);
        } else {
            $beans = $this->findAll(self::TABLE_CATEGORIES, 'parent_id IS NOT NULL');
        }

        return array_values(array_map([$this, 'mapBeanToArray'], $beans));
    }


    public function getAllCategoriesArray(): array
    {
        // Достаём все категории без фильтра
        $beans = $this->findAll(self::TABLE_CATEGORIES);

        // Сбрасываем ключи и преобразуем в массивы
        return array_values(array_map([$this, 'mapBeanToArray'], $beans));
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

        $parentBean = R::findOne(self::TABLE_CATEGORIES, 'id = ?', [$id]);

        if (!$parentBean) {
            return [];
        }

        $childrenBeans = $this->findAll(self::TABLE_CATEGORIES, 'parent_id = ?', [$id]);
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

        return $this->countAll(self::TABLE_CATEGORIES, 'parent_id = ?', [$id]) > 0;
    }

    public function getAllCategoriesCount(?string $sql = null, array $params = []): int
    {
      return $this->countAll(self::TABLE_CATEGORIES, $sql, $params);
    }

}
