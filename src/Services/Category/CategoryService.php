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
        $this->repository = new CategoryRepository($this->locale);
        $this->translationRepo = new CategoryTranslationRepository();
    }

    public function getCategoryById(int $id): ?Category
    {
        $category = $this->repository->getCategoryById($id);

        if (!$category) {
            return [];
        }

        $translations = $this->translationRepo->getTranslationsArray($id, $this->locale) 
        ?? 
        $this->translationRepo->getTranslationsArray($id, $this->defaultLocale);
       
        $category->setTranslations($translations);

        return $category;
    }


    public function getMainCategoriesArray(): array
    {
      return $this->repository->getMainCategoriesArray($this->locale);
    }

    public function getSubCategoriesArray($parent_id = null): array
    {
      return $this->repository->getSubCategoriesArray($this->locale, $parent_id);
    }

    public function getAllCategoriesArray(): array
    {
      $categories = $this->repository->getAllCategoriesArray();

      if (empty($categories)) {
        return [];
      }

      $this->setCategoriesWithTranslations($categories);

      return $categories;
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
                'title' => $category->getTranslatedTitle($this->locale),
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
              $this->locale => [
                  'title' => $category->getTranslatedTitle() ?? '',
                  'description' => $category->getTranslatedDescription() ?? '',
                  'seo_title' => $category->getSeoTitle() ?? '',
                  'seo_description' => $category->getSeoDescription() ?? '',
              ]
          ],
          'locale' => $this->locale,
      ]);
    }

    private function setCategoriesWithTranslations(array $categories): array
    {
        foreach ($categories as $category) {
            $translations = $this->translationRepo->getTranslationsArray($category->getId(), $this->locale);
            $category->setTranslations($translations);
        }
        return $categories;
    }

}
