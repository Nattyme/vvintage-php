<?php

declare(strict_types=1);

namespace Vvintage\Services\PostCategory;

/** Модель */
use Vvintage\Models\PostCategory\PostCategory;

use Vvintage\Repositories\PostCategory\PostCategoryRepository;
use Vvintage\Repositories\PostCategory\PostCategoryTranslationRepository;

use Vvintage\DTO\PostCategory\PostCategoryListInBlogDto;

use Vvintage\Services\Base\BaseService;
use Vvintage\Services\Post\PostService;
use Vvintage\Services\Locale\LocaleService;

require_once ROOT . "./libs/functions.php";

class PostCategoryService 
{
    private string $currentLang;

    public function __construct(
        protected PostCategoryRepository $repository,
        protected PostCategoryTranslationRepository $translationRepo,
        protected LocaleService $localeService
    )
    {
        $this->currentLang = $this->localeService->getCurrentLang();
    }

    public function getCategoryById(int $id, ?string $currentLang = null): ?PostCategory
    {
      if(!$id) return null;
      
      $category = $this->repository->getCategoryById($id);

      $id = $category->getId();
      $translations = $this->translationRepo->loadTranslations($id);
      $category->setTranslations($translations);

      return $category;
    }

    public function getCategoryBySlug(?string $slug): ?PostCategory
    {
      if(!$slug) return null;
      return $this->repository->getCategoryBySlug($slug);
    }

    public function getMainCategoriesArray(): array
    {
      return $this->repository->getMainCategoriesArray();
    }

    public function getSubCategoriesArray($parent_id = null): array
    {
      return $this->repository->findCatsByParentId($parent_id);
    }

    public function getAllCategoriesArray(): array
    {
      return $this->repository->getAllCategoriesArray();
    }


    public function getMainCategories(): array
    {
      $categories = $this->repository->getMainCats();

      if (!$categories) {
        return [];
      }
      $categoriesWithTranslation = array_map(function ($category) {
        
        $this->addCategoryTranslate($category);
    
          return new PostCategoryListInBlogDto(
            id: $category->getId(),
            parent_id: $category->getParentId(),
            slug: $category->getSlug(),
            title: $category->getTranslation($this->currentLang)['title'],
          );
      }, $categories);

      return array_values($categoriesWithTranslation);
    }

    public function getSubCategories(): array
    {
      $categories = $this->repository->getSubCats();
      
      if (!$categories) {
        return [];
      }
        
      $categoriesWithTranslation = array_map(function ($category) {
          $this->addCategoryTranslate($category);

          return new PostCategoryListInBlogDto(
            id: $category->getId(),
            parent_id: $category->getParentId(),
            slug: $category->getSlug(),
            title: $category->getTranslation($this->currentLang)['title'],
          );

      }, $categories);

      return array_values($categoriesWithTranslation);
    }

    public function getCategoriesWithPosts(): array
    {
        return array_values(array_filter(
            $this->repository->getMainCats(),
            fn($cat) => $this->postService->getPostsCountByCategory($cat->getId()) > 0
        ));
    }


    
    private function addCategoryTranslate(PostCategory $category): PostCategory
    {
        $id = (int) $category->getId();

        $translations = $this->translationRepo->loadTranslations($id) ?? [];
        $category->setTranslations($translations );

        return $category;
    }

    // TODO: проверить методы ниже на актуальность
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

    public function getAllCategoriesCount(): int
    {
       return $this->repository->getAllCategoriesCount();
    }

   

  
}
