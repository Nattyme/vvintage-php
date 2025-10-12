<?php
declare(strict_types=1);

namespace Vvintage\DTO\PostCategory;

use Vvintage\Models\PostCategory\PostCategory;

final class PostCategoryListInBlogDto 
{
    public ?int $parent_id;
    public string $title;

    public function __construct(PostCategory $data, $currentLang)
    {

        $translations = $data->getTranslation($currentLang) ?? [];
      
        $this->parent_id = (int) ($data->getParentId() ?? null);
        $this->title = (string) ($translations['title'] ?? '');     
    }

}
