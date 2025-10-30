<?php

declare(strict_types=1);

namespace Vvintage\Contracts\Category;

use RedBeanPHP\R;
use RedBeanPHP\OODBBean;

interface CategoryTranslationRepositoryInterface
{
  
  /** Создаёт новый OODBBean для перевода продукта */
  public function createCategoryTranslateBean(): OODBBean;
  public function loadTranslations(int $categoryId): array;
  public function findTranslations(int $id, string $locale);
  public function createTranslation(int $id, string $locale): void;
  public function updateTranslations( OODBBean $transBean, array $translation);

}
