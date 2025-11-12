<?php

declare(strict_types=1);

namespace Vvintage\Repositories\Category;


use RedBeanPHP\R;
use RedBeanPHP\OODBBean;

use Vvintage\Contracts\Category\CategoryRepositoryInterface; // Контракт
use Vvintage\Repositories\AbstractRepository; // Абстрактный репозиторий 
use Vvintage\Models\Category\Category; // Модель


final class CategoryRepository extends AbstractRepository implements CategoryRepositoryInterface
{
    private const TABLE = 'categories';

    public function saveCategory(array $data): int
    {
        // сохраняем или обновляем категорию
        $bean = $data['id']
            ? $this->loadBean(self::TABLE, $data['id'])
            : $this->createBean(self::TABLE);

        $bean->parent_id = !empty($data['parent_id']) ? (int) $data['parent_id'] : null;
        $bean->title = $data['title']; // по умолчанию ru
        $bean->description = $data['description'];
        $bean->slug = $data['slug'];
        $bean->image = $data['image'];

        $this->saveBean($bean);

        $id = (int) $bean->id;

        if (!$id) throw new RuntimeException("Не удалось сохранить категорию");

        return $id;
    }

    public function updateCategory(Category $cat): int
    {

      if (!$cat->getId()) {
          return null; // нельзя обновить без ID
      }

      return $this->saveCategory($cat);
    }

    public function deleteCategory(int $id): void
    {
      $bean = $this->loadBean(self::TABLE, $id);
      $this->deleteBean($bean);
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
        $beans = $this->findAll(table: self::TABLE, orderBy: 'parent_id ASC');
    
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
        $beans = $this->findAll(table: self::TABLE, conditions: ['parent_id IS NOT NULL']);
        return array_map([$this, 'mapBeanToCategory'], $beans);
    }



    public function findCatsByParentId(?int $parentId = null): array
    {
        if ($parentId === null) {
            $beans = $this->findAll(table: self::TABLE, conditions: ['parent_id IS NULL']);
        } else {
            $beans = $this->findAll(table: self::TABLE, conditions: ['parent_id = ?'], params: [$parentId]);
        }

        return array_map([$this, 'mapBeanToCategory'], $beans);
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




    public function getParentCategory(int $id): ?Category
    {
      if(!$id) {
        return null;
      }

      return $this->getCategoryById($id);
    }

    public function getAllCategoriesCount(?string $sql = null, array $params = []): int
    {
      return $this->countAll(self::TABLE, $sql, $params);
    }

}
