<?php

declare(strict_types=1);

namespace Vvintage\Services\Category;

/** Модель */
use Vvintage\Models\Category\Category;
use Vvintage\Repositories\Category\CategoryRepository;

require_once ROOT . "./libs/functions.php";

final class CategoryService
{
    private array $languages;
    private string $currentLang;
    private CategoryRepository $repository;

    public function __construct($languages, $currentLang)
    {
        $this->languages = $languages;
        $this->currentLang = $currentLang;
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

    // public function countSubCats(): int
    // {
    // }

}
