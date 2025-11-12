<?php
declare(strict_types=1);

namespace Vvintage\Public\DTO\Category;

use Vvintage\Config\LanguageConfig; 
use Vvintage\Models\Category\Category;
use Vvintage\Public\DTO\Category\CategoryCardDTO;

final readonly class CategoryCardDTOFactory
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
