<?php
declare(strict_types=1);

namespace Vvintage\DTO\Category;

use Vvintage\Models\Category\Category;
use Vvintage\DTO\Category\CategoryForProductDTO;

final class CategoryForProductDTOFactory
{
 
    public function createFromCategory(Category $category, string $currentLang): CategoryForProductDTO
    {
      $translations = (array) $category->getTranslations('$currentLang') ?? [];
    
      return new CategoryForProductDTO(
          id: (int) $category->getId(),
          parent_id: (int) $category->getParentId(),
          title: (string) ($translations['title'] ?? $category->getTitle() ?? '')
      );
    }

}
