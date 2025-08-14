<?php 
declare(strict_types=1);

namespace Vvintage\Services\Admin\Category;

use Vvintage\Services\Category\CategoryService;


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

  

}
