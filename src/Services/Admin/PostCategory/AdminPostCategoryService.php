<?php 
declare(strict_types=1);

namespace Vvintage\Services\Admin\PostCategory;

/** Модель */
use Vvintage\Models\PostCategory\PostCategory;
use Vvintage\Services\PostCategory\PostCategoryService;
use Vvintage\DTO\PostCategory\PostCategoryInputDTO;
use Vvintage\DTO\Admin\PostCategory\PostCategoryAdminListDTOFactory;
use Vvintage\DTO\Admin\PostCategory\EditDtoFactory;
use Vvintage\DTO\Admin\PostCategory\PostCategoryAdminListDTO;
use Vvintage\DTO\Admin\PostCategory\EditDto;


final class AdminPostCategoryService extends PostCategoryService
{

    public function __construct()
    {
      parent::__construct();
    }

    public function getAllCategoriesCount(): int 
    {
      return $this->repository->getAllCategoriesCount();
    }

    public function createCategory( PostCategory $cat)
    {
      return $this->repository->createCategory($cat); 
    }

    public function updateCategory( PostCategoryInputDTO $dto)
    {
   
      $category = PostCategory::fromInputDTO($dto);
  
      return $this->repository->updateCategory($category); 
    }

    public function deleteCategory(int $id): void
    {
      $this->repository->deleteCategory($id);
    }


    public function getAllCategoriesAdminList(): array
    {
        $categories = $this->repository->getAllCategories();
        $result = [
            'main' => [],
            'categories' => [],
        ];

        foreach ($categories as $category) {
            $dto = $this->getCategoryAdminListDto($category);
            if ($dto->parent_id === 0) {
                $result['main'][] = $dto;
            } else {
                $result['categories'][] = $dto;
            }
        }

        return $result;
    }


    public function getCategoryAdminListDto (PostCategory $category): ?PostCategoryAdminListDTO
    {
        $dtoFactory = new PostCategoryAdminListDTOFactory();
        return $dtoFactory->createFromPostCategory($category);
    }

    public function getCategoryEditAdmin(int $id) : EditDto
    {
      $category = $this->getCategoryById($id);
      $parentCategory = $this->repository->getParentCategory($category) ?? null;

      return $this->getPostCategoryEditDto($category, $parentCategory);
    }

    public function getPostCategoryEditDto (PostCategory $category, PostCategory $parentCategory = null): EditDto
    {
        $dtoFactory = new EditDtoFactory();
        return $dtoFactory->createFromPostCategory($category, $parentCategory);
    }

  public function getCategoryEditAdminFromRequest(int $id, array $postData): EditDto
  {
      $category = $this->getCategoryById($id);
      $parentCategory = $this->repository->getParentCategory($category) ?? null;
      $factory = new EditDtoFactory();

      return $factory->createFromRequest($postData, $category, $parentCategory);
  }



  

}
