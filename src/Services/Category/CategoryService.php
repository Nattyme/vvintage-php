<?php

declare(strict_types=1);

namespace Vvintage\Services\Category;

/** Модель */
use Vvintage\Models\Category\Category;
use Vvintage\Services\Locale\LocaleService;
use Vvintage\Repositories\Category\CategoryRepository;
use Vvintage\Repositories\Category\CategoryTranslationRepository;
use Vvintage\Services\Base\BaseService;

use Vvintage\DTO\Category\CategoryDTO;
use Vvintage\DTO\Category\CategoryTreeDto;
use Vvintage\DTO\Category\CategoryForProductDTO;
use Vvintage\DTO\Category\CategoryForProductDTOFactory;

require_once ROOT . "./libs/functions.php";

class CategoryService
{
    private $currentLang;
    public function __construct(
      private LocaleService $localeService,
      protected CategoryRepository $repository,
      protected CategoryTranslationRepository $translationRepo
    ) {
      $this->currentLang = $this->localeService->getCurrentLang();
    }

    public function getCategoryById(int $id): ?Category
    {
        $category = $this->repository->getCategoryById($id);

        if (!$category) {
            return null;
        }

        $translations = $this->translationRepo->loadTranslations($id);
  
        $category->setTranslations($translations);

        return $category;
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

    public function createCategoryProductDTO (int $id): CategoryForProductDTO
    {
      $category = $this->getCategoryById($id);
      $dtoFactory = new CategoryForProductDTOFactory();

      $dto = $dtoFactory->createFromCategory($category, currentLang: $this->currentLang);

      return $dto; 
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

    private function setCategoriesWithTranslations(array $categories): array
    {
        foreach ($categories as $category) {
            $id = (int) $category->getId();
          
            // $translations = $this->translationRepo->getLocaleTranslation( $id, $this->currentLang);
            $translations = $this->translationRepo->loadTranslations($id);
            $category->setTranslations($translations);
        }
        return $categories;
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

    // TODO: Проверить актулаьность методов ниже 

    public function getAllCategoriesArray(): array
    {
      $categories = $this->repository->getAllCategoriesArray();

      if (empty($categories)) {
        return [];
      }

      $this->setCategoriesWithTranslations($categories);

      return array_values($categories);
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

    public function getCategoryTree(): array
    {
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
                'title' => $category->getTitle(),
                // 'title' => $category->getTranslatedTitle($this->currentLang),
                'parent_id' => $category->getParentId(),
                'translations' => $category->getTranslations(),
                'children' => []
            ];
        }
    
        // связываем детей с родителями
        foreach ($categoriesById as $id => &$cat) {
            if ($cat['parent_id']) {
                $categoriesById[$cat['parent_id']]['children'][] = &$cat;
            } else {
                $tree[] = &$cat; // главная категория
            }
        }

        return $tree;
    }

    public function getCategoryTreeDTO(): array
    {
      $categories = $this->getCategoryTree();
      return array_map(fn($cat) => new  CategoryTreeDto($cat, $this->currentLang), $categories);
    }

    public function getAllCategoriesCount(): int
    {
       return $this->repository->getAllCategoriesCount();
    }





  

}
