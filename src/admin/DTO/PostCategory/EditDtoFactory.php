<?php
declare(strict_types=1);

namespace Vvintage\Admin\DTO\PostCategory;

use Vvintage\Config\LanguageConfig; 

/** Model */
use Vvintage\Models\PostCategory\PostCategory;
use Vvintage\Admin\DTO\PostCategory\EditDto;

final class EditDtoFactory
{
    public function createFromPostCategory(PostCategory $category, PostCategory $parentCategory = null): EditDto
    {
        $isMain = $parentCategory === null;
        

        return new EditDto(
            isMain : $isMain,
            id: (int) $category->getId(),
            title: (string) ($category->getTitle() ?? ''),
            description : (string) ($category->getDescription() ?? ''),
            slug: (string) ($category->getSlug() ?? ''),
            parent_id: $parentCategory ? (int) $parentCategory->getId() : null,
            parent_title: $parentCategory ? (string) $parentCategory->getTitle() : null,
            translations: (array) ($category->getTranslation() ?? []),
        );
    }
}
