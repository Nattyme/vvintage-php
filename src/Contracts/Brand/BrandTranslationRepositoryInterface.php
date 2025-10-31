<?php

declare(strict_types=1);

namespace Vvintage\Contracts\Brand;

use Vvintage\Models\Brand\Brand;
use RedBeanPHP\OODBBean;

interface BrandTranslationRepositoryInterface
{
  public function createTranslationsBean(): OODBBean;
  public function loadTranslations(int $id): array;
  public function saveBrandTranslation(array $translations): array;
  public function getLocaleTranslation(int $id, string $locale): array;
}
