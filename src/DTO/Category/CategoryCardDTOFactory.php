<?php
declare(strict_types=1);

namespace Vvintage\DTO\Category;


use Vvintage\Config\LanguageConfig; 

/** Model */
use Vvintage\Models\Category\Category;
use Vvintage\DTO\Category\CategoryCardDTO;

final class CategoryCardDTOFactory
{
    public function createFromCategory(Category $category, string $currentLang): CategoryCardDTO
    {
      $translations = (array) $category->getTranslations() ?? [];
     
        return new CategoryCardDTO(
            id: (int) $category->getId(),
            parent_id: (int) $category->getParentId(),
            title: (string) ($translations['title'] ?? $category->getTitle() ?? ''),
            slug: (string) ($category->getSlug() ?? ''),
            image: (string) ($category->getImage() ?? ''),
        );
    }
}
