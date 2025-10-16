<?php
declare(strict_types=1);

namespace Vvintage\DTO\Brand;

use Vvintage\Models\Brand\Brand;
use Vvintage\DTO\Brand\BrandForProductDTO;

final class BrandForProductDTOFactory
{
 
    public function createFromBrand(Brand $brand, string $currentLang): BrandForProductDTO
    {
      $translations = (array) $brand->getTranslations($currentLang) ?? [];
   
      return new BrandForProductDTO(
          id: (int) $brand->getId(),
          title: (string) ($translations['title'] ?? $brand->getTitle() ?? '')
      );
    }

}
