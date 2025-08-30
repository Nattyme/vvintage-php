<?php 
declare(strict_types=1);

namespace Vvintage\Services\Admin\PostCategory;

/** Модель */
use Vvintage\Models\PostCategory\PostCategory;
use Vvintage\Services\PostCategory\PostCategoryService;
use Vvintage\DTO\PostCategory\PostCategoryInputDTO;


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

    public function updateCategory( PostCategory $cat)
    {
      return $this->repository->updateCategory($cat); 
    }

  

}
