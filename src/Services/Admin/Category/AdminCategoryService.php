<?php 
declare(strict_types=1);

namespace Vvintage\Services\Admin\Category;

/** Модель */
use Vvintage\Models\Category\Category;
use Vvintage\Services\Category\CategoryService;
use Vvintage\DTO\Category\CategoryInputDTO;


final class AdminCategoryService extends CategoryService
{

    public function __construct()
    {
      parent::__construct();
    }

    public function getAllCategoriesCount(): int 
    {
      return $this->repository->getAllCategoriesCount();
    }

    public function createCategory( Category $cat)
    {
      return $this->repository->createCategory($cat); 
    }

  

}
