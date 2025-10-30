<?php
declare(strict_types=1);

namespace Vvintage\DTO\Admin\Brand;

use Vvintage\DTO\Admin\Brand\BrandTranslationInputDTO;

final class BrandTranslationInputDTOFactory
{
 
    public function createFromArray(array $translate, string $locale, int $brandId): BrandTranslationInputDTO
    {
        return new BrandTranslationInputDTO(
            brand_id: (int) $brandId,
            locale: (string) $locale, 
            title: (string) ($translate['title'] ?? ''),
            description: (string) ($translate['description'] ?? ''),
            meta_title: (string) ($translate['meta_title'] ?? $translate['title'] ?? ''),
            meta_description: (string) ($translate['meta_description'] ?? $translate['description'] ?? '')
        );
    }

}
