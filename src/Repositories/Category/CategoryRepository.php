<?php

declare(strict_types=1);

namespace Vvintage\Repositories\Category;


use RedBeanPHP\R;
use RedBeanPHP\OODBBean;

/** Контракты */
use Vvintage\Contracts\Category\CategoryRepositoryInterface;

/** Абстрактный репозиторий */
use Vvintage\Repositories\AbstractRepository;
use Vvintage\Repositories\Category\CategoryTranslationRepository;

use Vvintage\Models\Category\Category;
use Vvintage\DTO\Category\CategoryDTO;
use Vvintage\DTO\Category\CategoryOutputDTO;
use Vvintage\DTO\Admin\Category\CategoryInputDTO;


// final class CategoryRepository extends AbstractRepository implements CategoryRepositoryInterface
final class CategoryRepository extends AbstractRepository
{
    private const TABLE = 'categories';
    private CategoryTranslationRepository $translationRepo;

    public function __construct()
    {
      //  $this->currentLang = $currentLang;
       $this->translationRepo = new CategoryTranslationRepository();
    }


    private function mapBeanToCategory(OODBBean $bean): Category
    {
      return Category::fromArray([
          'id' => (int) $bean->id,
          'parent_id' => (int) $bean->parent_id,
          'title' => (string) $bean->title,
          'description' => (string) $bean->description,
          'slug' => (string) $bean->slug,
          'image' => (string) $bean->image,
      ]);

    }

    private function mapBeanToCategoryArray (OODBBean $bean): array
    {
     
      return [
          'id' => (int) $bean->id,
          'title' => (string) $bean->title,
          'parent_id' => (int) $bean->parent_id,
          'image' => (string) $bean->image
      ];
    }


    public function getCategoryById(int $id): ?Category
    {
        $bean = $this->findById(self::TABLE, $id);

        if (!$bean || !$bean->id) {
            return null;
        }

        return $this->mapBeanToCategory($bean);
    }


    public function getAllCategories(): array
    {
        $beans = $this->findAll(table: self::TABLE);
    
        return array_map([$this, 'mapBeanToCategory'], $beans);
    }

    public function getAllCategoriesApi(): array
    {
        $beans = $this->findAll(table: self::TABLE);
   
        return array_map([$this, 'mapBeanToCategoryArray'], $beans);
    }

    public function getMainCats(): array
    {
        return $this->findCatsByParentId();
    }

    public function getSubCats(): array
    {
        // $beans = $this->findAll(table: self::TABLE, 'parent_id IS NOT NULL');
        $beans = $this->findAll(table: self::TABLE, conditions: ['parent_id IS NOT NULL']);
        return array_map([$this, 'mapBeanToCategory'], $beans);
    }

    public function findCatsByParentId(?int $parentId = null): array
    {
        if ($parentId === null) {
            // $beans = $this->findAll(table: self::TABLE, 'parent_id IS NULL');
            $beans = $this->findAll(table: self::TABLE, conditions: ['parent_id IS NULL']);
        } else {
            // $beans = $this->findAll(self::TABLE, 'parent_id = ?', [$parentId]);
            $beans = $this->findAll(table: self::TABLE, conditions: ['parent_id = ?'], params: [$parentId]);
        }

        return array_map([$this, 'mapBeanToCategory'], $beans);
    }

    public function saveCategory(CategoryInputDTO $dto): int
    {
     
        // сохраняем основную категорию
        $bean = $dto->id
            ? $this->loadBean(self::TABLE, $dto->id)
            : $this->createBean(self::TABLE);

        $bean->parent_id = !empty($dto->parent_id) ? (int)$dto->parent_id : null;
        $bean->title = $dto->title; // по умолчанию ru
        $bean->description = $dto->description;
        $bean->slug = $dto->slug;
        $bean->image = $dto->image;

        $id = (int) $this->saveBean($bean);

        // НЕ удаляем все переводы
        // foreach ($cat->getAllTranslations() as $locale => $translation) {
        //   // ищем перевод для этой локали
        //   $transBean =  $this->translationRepo->findTranslations($id, $locale);

        //   if (!$transBean) {
        //     // если нет — создаём новый
        //     $this->translationRepo->createTranslation($id, $locale);
        //   }

        //   $this->translationRepo->updateTranslations( $transBean, $translation);
        // }

        return $id;
    }

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

    
    // Для api
    public function createMainCategoriesArray(): array
    {
        $beans = $this->findAll(table: self::TABLE, conditions: ['parent_id IS NULL']);

        return array_map(function ($bean) {
            return [
                'id' => $bean->id,
                'parent_id' => $bean->parent_id,
                'slug' => $bean->slug,
                'image' => $bean->image,
            ];
        }, $beans);
      
    }


    public function createSubCategoriesArray(?int $parent_id = null): array
    {

        if ($parent_id !== null) {
            $beans = $this->findAll(table: self::TABLE, conditions: ['parent_id = ?'], params: [$parent_id]);
        } else {
            $beans = $this->findAll(table: self::TABLE, conditions: ['parent_id IS NOT NULL']);
        }

        return array_map(function ($bean) {
            return [
                'id' => $bean->id,
                'parent_id' => $bean->parent_id,
                'slug' => $bean->slug,
                'image' => $bean->image,
            ];
        }, $beans);

    }


    public function getAllCategoriesArray(): array
    {
        // Достаём все категории без фильтра
        $beans = $this->findAll(table: self::TABLE);

        // Сбрасываем ключи и преобразуем в массивы
        return array_values(array_map([$this, 'mapBeanToCategory'], $beans));
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

        $childrenBeans = $this->findAll(table: self::TABLE, conditions: ['parent_id = ?'], params: [$id]);
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
