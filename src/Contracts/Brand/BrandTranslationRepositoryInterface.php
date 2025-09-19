<?php

declare(strict_types=1);

namespace Vvintage\Contracts\Brand;

use Vvintage\Models\Brand\Brand;
use RedBeanPHP\OODBBean;

interface BrandTranslationRepositoryInterface
{
  public function createTranslationsBean(): OODBBean;
  public function getTranslationsArray(int $id, string $locale): array;
  public function loadTranslations(int $id): array;

  // public function findTranslations(int $id, string $locale);

  public function saveTranslations($brandId, $locale, $fields): void;
}
