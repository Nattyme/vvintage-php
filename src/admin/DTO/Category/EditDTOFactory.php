<?php
declare(strict_types=1);

namespace Vvintage\admin\DTO\Category;

/** Model */
use Vvintage\Models\Category\Category;
use Vvintage\DTO\Admin\Category\EditDTO;
use Vvintage\Config\LanguageConfig;

final class EditDTOFactory
{
    public function createFromCategory(Category $category, Category $parentCategory = null): EditDTO
    {
        $isMain = $parentCategory === null;
        $defaultLang = LanguageConfig::getDefault();

        return new EditDTO(
            isMain : $isMain,
            id: (int) $category->getId(),
            title: (string) ($category->getTitle($defaultLang) ?? ''),
            description : (string) ($category->getDescription($defaultLang) ?? ''),
            slug: (string) ($category->getSlug() ?? ''),
            parent_id: $parentCategory ? (int) $parentCategory->getId() : null,
            parent_title: $parentCategory ? (string) $parentCategory->getTitle($defaultLang) : null,
            translations: (array) ($category->getTranslations() ?? []),
        );
    }
}
