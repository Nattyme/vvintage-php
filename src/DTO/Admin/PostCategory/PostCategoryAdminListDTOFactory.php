<?php
declare(strict_types=1);

namespace Vvintage\DTO\Admin\PostCategory;

use Vvintage\Config\LanguageConfig; 

/** Model */
use Vvintage\Models\PostCategory\PostCategory;
use Vvintage\DTO\Admin\PostCategory\PostCategoryAdminListDTO;

final class PostCategoryAdminListDTOFactory
{
    public function createFromPostCategory(PostCategory $category): PostCategoryAdminListDTO
    {
        return new PostCategoryAdminListDTO(
            id: (int) ($category->getId() ?? null),
            parent_id: (int) ($category->getParentId() ?? 0),
            title: (string) ($category->getTitle() ?? ''),
            slug: (string) ($category->getSlug() ?? ''),
        );
    }
}
