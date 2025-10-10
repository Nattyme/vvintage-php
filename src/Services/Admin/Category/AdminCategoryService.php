<?php 
declare(strict_types=1);

namespace Vvintage\Services\Admin\Category;

/** Модель */
use Vvintage\Models\Category\Category;
use Vvintage\Services\Category\CategoryService;
use Vvintage\DTO\Admin\Category\CategoryInputDTO;


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


          // $translateDto = $this->createTranslateInputDto($translations, $categoryId);

          // if (empty($translateDto)) {
          //   throw new \RuntimeException("Не удалось сохранить категорию");
          //   return null;
          // }
    
          // foreach($translateDto as $dto) {
          //   $result = $this->translationRepo->saveTranslations($categoryId, $dto->locale, $dto);
          // }
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
              'title' => $data['title'] ?? null,
              'description' => $textData['description'] ?? null,
              'image' => $textData['image'] ?? null
          ]);

      return $dataDto;
        // 'title' => $data['translations']['ru']['title'] ?? '',
        //       'description' => $textData['translations']['ru']['description'] ?? '',
        //       'image' => $textData['image'] ?? null,
        //       'translations' => $textData['translations']
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
