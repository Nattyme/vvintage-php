<?php

declare(strict_types=1);

namespace Vvintage\Services\Category;

/** Модель */
use Vvintage\Models\Category\Category;
use Vvintage\Repositories\Category\CategoryRepository;
use Vvintage\Services\Base\BaseService;

require_once ROOT . "./libs/functions.php";

final class CategoryService extends BaseService
{
    private CategoryRepository $repository;

    public function __construct($languages, $currentLang)
    {
        parent::__construct();
        $this->repository = new CategoryRepository($this->currentLang);
    }


    public function getMainCategories(): array
    {
      return $this->repository->getMainCats();
    }


    public function getMainCategoriesArray(): array
    {
      return $this->repository->getMainCategoriesArray();
    }

    public function getSubCategoriesArray($parent_id = null): array
    {
      return $this->repository->getSubCategoriesArray($parent_id);
    }

    public function getAllCategoriesArray(): array
    {
      return $this->repository->getAllCategoriesArray();
    }

    // public function countSubCats(): int
    // {
    // }

    public function getAllCategories(): array
    {
       $this->repository->getAllCategories(); 
    }

}
