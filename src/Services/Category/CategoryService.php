<?php

declare(strict_types=1);

namespace Vvintage\Services\Category;

/** Модель */
use Vvintage\Models\Category\Category;
use Vvintage\Repositories\Category\CategoryRepository;
use Vvintage\Services\Base\BaseService;

require_once ROOT . "./libs/functions.php";

class CategoryService extends BaseService
{
    protected CategoryRepository $repository;

    public function __construct()
    {
        parent::__construct();
        $this->repository = new CategoryRepository($this->currentLang);
    }

    public function getCategoryById(int $id): ?Category
    {
      return $this->repository->getCategoryById($id);
    }

    public function getMainCategoriesArray(): array
    {
      return $this->repository->getMainCategoriesArray();
    }

    public function getSubCategoriesArray($parent_id = null): array
    {
      return $this->repository->getSubCategoriesArray($parent_id);
    }

    public function getAllCategoriesArray(): array
    {
      return $this->repository->getAllCategoriesArray();
    }


    
    public function getMainCategories(): array
    {
      return $this->repository->getMainCats();
    }
    public function getSubCategories(): array
    {
      return $this->repository->getSubCats();
    }
    public function getAllCategories($pagination = null): array
    {
      return $this->repository->getAllCategories($pagination);
    }

    public function getCategoryTree() {
        // Получим все категории
        $allCategories = $this->repository->getAllCategories(); 
        $tree = [];

        // сначала создаём индекс категорий по id
        $categoriesById = [];
        foreach ($allCategories as $category) {
            $categoriesById[$category->getId()] = [
                'id' => $category->getId(),
                'title' => $category->getTranslatedTitle($this->currentLang),
                'parentId' => $category->getParentId(),
                'children' => []
            ];
        }

        // связываем детей с родителями
        foreach ($categoriesById as $id => &$cat) {
            if ($cat['parentId']) {
                $categoriesById[$cat['parentId']]['children'][] = &$cat;
            } else {
                $tree[] = &$cat; // главная категория
            }
        }

        return $tree;
    }

  
}
