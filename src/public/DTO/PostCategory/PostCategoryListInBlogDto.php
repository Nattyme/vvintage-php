<?php
declare(strict_types=1);

namespace Vvintage\Public\DTO\PostCategory;

use Vvintage\Models\PostCategory\PostCategory;

final class PostCategoryListInBlogDto 
{
    public function __construct(
      public int $id,
      public int $parent_id,
      public string $slug,
      public string $title
    )
    {

        // $translations = $data->getTranslation($currentLang) ?? [];
      
        // $this->id = (int) ($data->getId() ?? null);
        // $this->parent_id = (int) ($data->getParentId() ?? null);
        // $this->title = (string) ($translations['title'] ?? '');     
    }

}
