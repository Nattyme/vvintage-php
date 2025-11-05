<?php
declare(strict_types=1);

namespace Vvintage\Admin\DTO\Brand;

/** Model */
use Vvintage\Models\Brand\Brand;
use Vvintage\Admin\DTO\Brand\EditDTO;

final class EditDTOFactory
{
    public function createFromBrand(Brand $brand): EditDTO
    {
  
        return new EditDTO(
            id: (int) $brand->getId(),
            title: (string) ($brand->getTitle() ?? ''),
            description : (string) ($brand->getDescription() ?? ''),
            image: (string) ($brand->getImage() ?? ''),
            translations: (array) ($brand->getTranslations() ?? []),
        );
    }
}
