<?php

declare(strict_types=1);

namespace Vvintage\Services\Category;

/** Модель */
use Vvintage\Models\Category\Category;
use Vvintage\Repositories\Category\CategoryRepository;
use Vvintage\Repositories\Category\CategoryTranslationRepository;
use Vvintage\Services\Base\BaseService;

use Vvintage\DTO\Category\CategoryDTO;
use Vvintage\DTO\Category\CategoryOutputDTO;

require_once ROOT . "./libs/functions.php";

class CategoryService extends BaseService
{
    protected CategoryRepository $repository;
    protected CategoryTranslationRepository $translationRepo;

    public function __construct() {
        parent::__construct();
        $this->repository = new CategoryRepository();
        $this->translationRepo = new CategoryTranslationRepository();
    }

    public function getCategoryById(int $id): ?Category
    {
        $category = $this->repository->getCategoryById($id);

        if (!$category) {
            return [];
        }

        $translations = $this->translationRepo->getLocaleTranslation((int) $id, $this->currentLang) 
        ?? 
        $this->translationRepo->getLocaleTranslation((int) $id, $this->defaultLocale);
       
        $category->setTranslations($translations);

        return $category;
    }


    // Методы возвращают массив для api
    public function getMainCategoriesArray(): array
    {
        $categories = $this->repository->createMainCategoriesArray();

        if (!$categories) {
          return [];
        }
        
        $categoriesWithTranslation = array_map(function ($category) {
            return $this->addCategoryTranslate($category);
        }, $categories);

        return array_values($categoriesWithTranslation);
    }

    public function getSubCategoriesArray(?int $parent_id = null): array
    {
        $categories = $this->repository->createSubCategoriesArray($parent_id);
        $categoriesWithTranslation = array_map(function ($category) {
            return $this->addCategoryTranslate($category);
        }, $categories);

        return array_values($categoriesWithTranslation);
    }

    
    public function getAllCategoriesArrayApi(): array
    {
      $categories = $this->repository->getAllCategoriesApi();


      if (empty($categories)) {
        return [];
      }

      $categoriesWithTranslation = array_map(function ($category) {
                                      return $this->addCategoryTranslate($category);
                                  }, $categories);

      return array_values($categoriesWithTranslation);
    }


    private function addCategoryTranslate(array $category): array
    {
        $id = (int) $category['id'];

        error_log(print_r($id, true));
        $translations = $this->translationRepo->getLocaleTranslation($id, $this->currentLang) ?? [];

        return array_merge($category, [
            'title' => $translations['title'] ?? null,
            'description' => $translations['description'] ?? null,
            'seo_title' => $translations['meta_title'] ?? null,
            'seo_description' => $translations['meta_description'] ?? null,
        ]);
    }












    public function getAllCategoriesArray(): array
    {
      $categories = $this->repository->getAllCategoriesArray();


      if (empty($categories)) {
        return [];
      }

      $this->setCategoriesWithTranslations($categories);

      return array_values($categories);
    }


    
    public function getMainCategories(): array
    {
      $categories = $this->repository->getMainCats();
      if (empty($categories)) {
        return [];
      }

      $this->setCategoriesWithTranslations($categories);

      return $categories;
    }
    public function getSubCategories(): array
    {
      $categories =  $this->repository->getSubCats();

      if (empty($categories)) {
        return [];
      }

      $this->setCategoriesWithTranslations($categories);

      return $categories;
    }

    public function getAllCategories($pagination = null): array
    {
      $categories =  $this->repository->getAllCategories($pagination);

      if (empty($categories)) {
        return [];
      }

      $this->setCategoriesWithTranslations($categories);

      return $categories;
    }

    public function getCategoryTree() {
        // Получим все категории
        $categories = $this->repository->getAllCategories();

        if (empty($categories)) {
          return [];
        }

        $this->setCategoriesWithTranslations($categories);

        $tree = [];

        // сначала создаём индекс категорий по id
        $categoriesById = [];
        foreach ($categories as $category) {
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

    public function getAllCategoriesCount(): int
    {
       return $this->repository->getAllCategoriesCount();
    }


    public function createCategoryOutputDTO (int $id): CategoryOutputDTO
    {
      $category = $this->getCategoryById($id);
   
      return new CategoryOutputDTO([
          'id' => (int) $category->getId(),
          'title' => (string) ($category->getTranslatedTitle() ?: $category->getTitle()),
          'parent_id' => (int) ($category->getParentId() ?? 0),
          'image' => (string) ($category->getImage() ?? ''),
          'translations' => [
              $this->currentLang => [
                  'title' => $category->getTranslatedTitle($this->currentLang) ?? '',
                  'description' => $category->getTranslatedDescription($this->currentLang) ?? '',
                  'seo_title' => $category->getSeoTitle($this->currentLang) ?? '',
                  'seo_description' => $category->getSeoDescription($this->currentLang) ?? '',
              ]
          ],
          'locale' => $this->currentLang,
      ]);
    }

    private function setCategoriesWithTranslations(array $categories): array
    {
        foreach ($categories as $category) {
            $id = (int) $category->getId();
          
            $translations = $this->translationRepo->getLocaleTranslation( $id, $this->currentLang);
            $category->setTranslations($translations);
        }
        return $categories;
    }

  

}
