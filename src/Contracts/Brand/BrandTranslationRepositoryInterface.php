<?php

declare(strict_types=1);

namespace Vvintage\Contracts\Brand;

use Vvintage\Models\Brand\Brand;
// use Vvintage\DTO\Brand\BrandDTO;



interface BrandTranslationRepositoryInterface
{
  public function createTranslationsBean(): OODBBean;

  public function loadTranslations(int $id): array;

  public function findTranslations(int $id, string $locale);

  public function saveTranslations($brandId, $locale, $fields): void;
}
