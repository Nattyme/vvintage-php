<?php
declare(strict_types=1);

namespace Vvintage\admin\DTO\Brand;

use Vvintage\Models\Brand\Brand;
use Vvintage\admin\DTO\Brand\BrandForAdminListDTO;
use Vvintage\admin\Services\Brand\AdminBrandService;
use Vvintage\Config\LanguageConfig; 

final class BrandsForAdminListDTOFactory
{
 
    public function createFromBrand(Brand $brand): BrandForAdminListDTO
    {
      $defaultLang = LanguageConfig::getDefault();
      $service = new AdminBrandService();
      $translations = $service->getTranslations($brand->getId()) ?? [];

      return new BrandForAdminListDTO(
          id: (int) $brand->getId(),
          title: (string) ($translations[$defaultLang]['title'] ?? $brand->getTitle() ?? ''),
          description: (string) ($translations[$defaultLang]['description'] ?? $brand->getDescription() ?? '')
      );
    }

}
