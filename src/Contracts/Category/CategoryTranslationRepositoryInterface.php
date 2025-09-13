<?php

declare(strict_types=1);

namespace Vvintage\Contracts\Category;

use Vvintage\Models\Category\Category;



interface CategoryTranslationRepositoryInterface
{
  
  /** Создаёт новый OODBBean для перевода продукта */
  public function createCategoryTranslateBean(): OODBBean;

  public function loadTranslations(int $categoryId): array;

  public function saveProductTranslation(array $translateDto): ?array;

  public function getTranslationsArray($id): array;

  public function findTranslations(int $id, string $locale);

  public function createTranslation();


  public function updateTranslations( OODBBean $transBean, array $translation);

}
