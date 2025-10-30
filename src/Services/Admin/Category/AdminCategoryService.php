<?php 
declare(strict_types=1);

namespace Vvintage\Services\Admin\Category;

/** Модель */
use Vvintage\Models\Category\Category;

/* Сервисы */
use Vvintage\Services\Admin\Validation\AdminCategoryValidator;
use Vvintage\Services\Category\CategoryService;

/* DTO */
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
        // Создаем дто категории
        $dto = $this->createCategoryInputDTO($data);

        if(!$dto) {
          throw new \RuntimeException("Не удалось создать категорию");
        }

        // Сохраняем в БД
        $categoryId = $this->repository->saveCategory($categoryDto->toArray());
      
        if(!$categoryId) {
          throw new \RuntimeException("Не удалось сохранить категорию");
        }

        if (empty($data['translations']) ) {
          throw new \RuntimeException("Не получены переводы. Не удалось сохранить новую категорию");
        }
  
        // Сохраняем перевод категории
        $translateDto = $this->createTranslateInputDto($data['translations'], $categoryId);

        // Приведем к массиву и передадим в БД
        $translateArray = array_map(function($item) { return $item->toArray(); }, $translateDto);
        $this->translationRepo->saveCategoryTranslation($translateArray);
        

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

    public function updateCategoryDraft(int $id, array $data): bool 
    {
        $this->repository->begin(); // начало транзакции

        try {
            // Обновляем категорию
            $categoryDto = $this->createCategoryInputDTO($data, $id);

            if(!$categoryDto) {
              throw new \RuntimeException("Не удалось обновить категорию");
            }

            $this->repository->saveCategory($categoryDto->toArray());
  

            // Обновляем перевод категории
            if (empty($data['translations']) ) {
              throw new \RuntimeException("Не получены переводы. Не удалось обновить категорию");
            }

            $translateDto = $this->createTranslateInputDto($data['translations'], $id);

            // Приведем к массиву и передадим в БД
            $translateArray = array_map(function($item) { return $item->toArray(); }, $translateDto);
            $this->translationRepo->saveCategoryTranslation($translateArray);

            // Подтверждаем транзакцию
            $this->repository->commit();

            return true;

        } catch (\Throwable $error) {
            $this->repository->rollback();
            throw $error;
        }
    }


    public function createCategoryInputDTO(array $data, ?int $id=null): ?CategoryInputDTO
    {
      $dataDto = new CategoryInputDTO([
              'id' => $id ?? null,
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
      if(empty($data['ru']) || empty($data['en'])) {
          throw new \RuntimeException("Не получены обязательные переводы ru и en. Не удалось обновить категорию.");
          return null;
      }
      

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

}
