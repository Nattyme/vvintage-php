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
use Vvintage\DTO\Category\CategoryOutputDTO;
use Vvintage\DTO\Category\CategoryInputDTO;


final class CategoryRepository extends AbstractRepository implements CategoryRepositoryInterface
{
    private const TABLE = 'categories';
    private const TABLE_CATEGORIES_TRANSLATION = 'categoriestranslation';
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
        $sql = 'SELECT locale, title, description, meta_title, meta_description FROM ' . self::TABLE_CATEGORIES_TRANSLATION .' WHERE category_id = ?';
        $rows = $this->getAll($sql, [$categoryId]);

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


        $dto = new CategoryInputDTO([
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
        $bean = $this->findById(self::TABLE, $id);

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
        $beans = $this->findAll(self::TABLE);
        return array_map([$this, 'mapBeanToCategory'], $beans);
    }

    public function getCategoriesByIds(array $ids): array
    {
        $beans = $this->findByIds(self::TABLE, $ids);

        return array_map([$this, 'mapBeanToCategory'], $beans);
    }

    public function getMainCats(): array
    {
        return $this->findCatsByParentId();
    }

    public function getSubCats(): array
    {
        $beans = $this->findAll(self::TABLE, 'parent_id IS NOT NULL');
        return array_map([$this, 'mapBeanToCategory'], $beans);
    }

    public function findCatsByParentId(?int $parentId = null): array
    {
        if ($parentId === null) {
            $beans = $this->findAll(self::TABLE, 'parent_id IS NULL');
        } else {
            $beans = $this->findAll(self::TABLE, 'parent_id = ?', [$parentId]);
        }

        return array_map([$this, 'mapBeanToCategory'], $beans);
    }

    public function saveCategory(Category $cat): int
    {
        // сохраняем основную категорию
        $bean = $cat->getId()
            ? $this->loadBean(self::TABLE, $cat->getId())
            : $this->createBean(self::TABLE);

        $bean->title = $cat->getTitle(); // по умолчанию ru
        $bean->parent_id = $cat->getParentId();
        $bean->slug = $cat->getSlug();
        $bean->image = $cat->getImage();
        $bean->seo_title = $cat->getSeoTitle();
        $bean->seo_description = $cat->getSeoDescription();

        $id = (int) $this->saveBean($bean);

        // НЕ удаляем все переводы
        foreach ($cat->getAllTranslations() as $locale => $translation) {
            // ищем перевод для этой локали
            $transBean = $this->findOneBy(
                self::TABLE_CATEGORIES_TRANSLATION,
                'category_id = ? AND locale = ?',
                [$id, $locale]
            );

            if (!$transBean) {
                // если нет — создаём новый
                $transBean = $this->createBean(self::TABLE_CATEGORIES_TRANSLATION);
                $transBean->category_id = $id;
                $transBean->locale = $locale;
            }

            // Обновляем только те поля, что реально пришли
            if (array_key_exists('title', $translation)) {
                $transBean->title = $translation['title'];
            }
            if (array_key_exists('description', $translation)) {
                $transBean->description = $translation['description'];
            }
            if (array_key_exists('meta_title', $translation)) {
                $transBean->meta_title = $translation['meta_title'];
            }
            if (array_key_exists('meta_description', $translation)) {
                $transBean->meta_description = $translation['meta_description'];
            }

            $this->saveBean($transBean);
        }

        return $id;
    }


    // public function saveCategory(Category $cat): int
    // {
    
    //     $bean = $cat->getId() ? $this->loadBean(self::TABLE_CATEGORIES, $cat->getId()) : $this->createBean(self::TABLE_CATEGORIES);

    //     $bean->title = $cat->getTitle(); // по умолчанию ru
    //     $bean->parent_id = $cat->getParentId();
    //     $bean->slug = $cat->getSlug();
    //     $bean->image = $cat->getImage();
    //     $bean->seo_title = $cat->getSeoTitle();
    //     $bean->seo_description = $cat->getSeoDescription();

    //     $id = (int) $this->saveBean($bean);

    //     // Сохраняем переводы в отдельную таблицу
    //     R::exec('DELETE FROM ' . self::TABLE_CATEGORIES_TRANSLATION .' WHERE category_id = ?', [$id]);
    //     foreach ($cat->getAllTranslations() as $locale => $translation) {
    //         $transBean = $this->createBean(self::TABLE_CATEGORIES_TRANSLATION);
    //         $transBean->category_id = $id;
    //         $transBean->locale = $locale;
    //         $transBean->title = $translation['title'] ?? '';
    //         $transBean->description = $translation['description'] ?? '';
    //         $transBean->meta_title = $translation['meta_title'] ?? '';
    //         $transBean->meta_description = $translation['meta_description'] ?? '';
    //         $this->saveBean($transBean);
    //     }

    //     return $id;
    // }
    // public function saveCategory(Category $cat): int
    // {
    //     $bean = $cat->getId() ? $this->loadBean(self::TABLE_CATEGORIES, $cat->getId()) : $this->createBean(self::TABLE_CATEGORIES);

    //     $bean->title = $cat->getTitle(); // по умолчанию ru
    //     $bean->parent_id = $cat->getParentId();
    //     $bean->image = $cat->getImage();
    //     $bean->seo_title = $cat->getSeoTitle();
    //     $bean->seo_description = $cat->getSeoDescription();

    //     $id = (int) $this->saveBean($bean);

    //     // Сохраняем переводы в отдельную таблицу
    //     R::exec('DELETE FROM ' . self::TABLE_CATEGORIES_TRANSLATION .' WHERE category_id = ?', [$id]);
    //     foreach ($cat->getAllTranslations() as $locale => $translation) {
    //         $transBean = $this->createBean(self::TABLE_CATEGORIES_TRANSLATION);
    //         $transBean->category_id = $id;
    //         $transBean->locale = $locale;
    //         $transBean->title = $translation['title'] ?? '';
    //         $transBean->description = $translation['description'] ?? '';
    //         $transBean->meta_title = $translation['meta_title'] ?? '';
    //         $transBean->meta_description = $translation['meta_description'] ?? '';
    //         $this->saveBean($transBean);
    //     }

    //     return $id;
    // }

    public function updateCategory(Category $cat): int
    {

      if (!$cat->getId()) {
          return null; // нельзя обновить без ID
      }

      return $this->saveCategory($cat);
    }

    public function createCategory(Category $cat): int 
    {
      return $this->saveCategory($cat);
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
        $beans = $this->findAll(self::TABLE);

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

        $parentBean = R::findOne(self::TABLE, 'id = ?', [$id]);

        if (!$parentBean) {
            return [];
        }

        $childrenBeans = $this->findAll(self::TABLE, 'parent_id = ?', [$id]);
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

        return $this->countAll(self::TABLE, 'parent_id = ?', [$id]) > 0;
    }

    public function getAllCategoriesCount(?string $sql = null, array $params = []): int
    {
      return $this->countAll(self::TABLE, $sql, $params);
    }

    public function deleteCategory(int $id): void
    {
      $bean = $this->loadBean(self::TABLE, $id);
      $this->deleteBean($bean);
    }


}
