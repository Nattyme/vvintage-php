<?php
declare(strict_types=1);

namespace Vvintage\DTO\PostCategory;

use Vvintage\Models\PostCategory\PostCategory;

final class PostCategoryListInBlogDto 
{
  
    public function __construct(
      public $id,
      public $parent_id,
      public $title
    )
    {

        // $translations = $data->getTranslation($currentLang) ?? [];
      
        // $this->id = (int) ($data->getId() ?? null);
        // $this->parent_id = (int) ($data->getParentId() ?? null);
        // $this->title = (string) ($translations['title'] ?? '');     
    }

}
