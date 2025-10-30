<?php 
declare(strict_types=1);

namespace Vvintage\Services\Admin\Category;

/** Модель */
use Vvintage\Models\Category\Category;
use Vvintage\Services\Category\CategoryService;
use Vvintage\DTO\Admin\Category\CategoryInputDTO;
use Vvintage\DTO\Admin\Category\CategoryTranslationInputDTO;
use Vvintage\DTO\Admin\Category\EditDTO;
use Vvintage\DTO\Admin\Category\EditDTOFactory;


final class AdminCategoryService extends CategoryService
{

    public function __construct()
    {
      parent::__construct();
    }

    public function createCategoryDraft(array $data): ?int
    {
      if (!$data ) return null;

      // начало транзакции
      $this->repository->begin(); 

      try {
        $dto = $this->createCategoryInputDTO($data);

        if(!$dto) {
          throw new \RuntimeException("Не удалось создать категорию");
          return null;
        }

        $categoryId = $this->repository->saveCategory($dto);
      
        if(!$categoryId) {
          throw new \RuntimeException("Не удалось сохранить категорию");
          return null;
        }
  
    
        if (!empty($data['translations'])) {
          $translateDto = $this->createTranslateInputDto($data['translations'], $categoryId);
        
          $this->translationRepo->saveCategoryTranslation($translateDto);
        }

        // Подтверждаем транзакцию
        $this->repository->commit();
        
        return $categoryId;
      }
      catch (\Throwable $error) 
      {
        $this->repository->rollback();
        throw $error;
      }
      
    }

    public function createCategoryInputDTO(array $data): ?CategoryInputDTO
    {
      $isNew = empty($data['id']); // если id нет — новая категория

      $dataDto = new CategoryInputDTO([
              'parent_id' => $data['parent_id'] ?? 0,
              'slug' => $data['slug'] ?? null,
              'title' => $data['translations']['ru']['title'] ?? null,
              'description' => $data['translations']['ru']['description'] ?? null,
              'image' => $data['image'] ?? null
          ]);

      return $dataDto;
    }

    private function createTranslateInputDto(array $data, int $categoryId): array
    {
      $categoryTranslationsDto = [];

      foreach($data as $locale => $translate) {
          $categoryTranslationsDto[] = new CategoryTranslationInputDTO([
              'category_id' => (int) ($categoryId ?? 0),
              'slug' => (string) ($translate['slug'] ?? ''),
              'locale' => (string) $locale, 
              'title' => (string) ($translate['title'] ?? ''),
              'description' => (string) ($translate['description'] ?? ''),
              'meta_title' => (string) ($translate['meta_title'] ?? $translate['title'] ?? ''),
              'meta_description' => (string) ($translate['meta_description'] ?? $translate['description'] ?? '')
          ]);
      }
          
      return  $categoryTranslationsDto;

    }

    private function createCategoryEditDTO(Category $category, ?Category $parentCategory): array
    {
      $translations = $this->translationRepo->loadTranslations($category->getId());
      $category->setTranslations($translations);
      dd( $category);
      $dtoFactory = new EditDtoFactory();

      return $dtoFactory->createFromCategory($category, $parentCategory);
    }


    public function getCategoryEditDTO (int $id): EditDto
    {
        $category = $this->getCategoryById($id);
        $parentCategoryId = $category->getParentId() ?? null;
        $parentCategory = $this->getCategoryById($parentCategoryId) ?? null;

        $dtoFactory = new EditDtoFactory();
        
        return $dtoFactory->createFromCategory($category, $parentCategory);
    }
    








    public function getAllCategoriesCount(): int 
    {
      return $this->repository->getAllCategoriesCount();
    }

    public function createCategory( Category $cat)
    {
      return $this->repository->saveCategory($cat); 
    }

    public function updateCategory( Category $cat)
    {
      return $this->repository->updateCategory($cat); 
    }

    public function deleteCategory(int $id): void
    {
      $this->repository->deleteCategory($id);
    }
}
