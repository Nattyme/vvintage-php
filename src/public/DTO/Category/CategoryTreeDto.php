<?php
declare(strict_types=1);

namespace Vvintage\Public\DTO\Category;
use Vvintage\Public\DTO\Category;

final class CategoryTreeDto 
{
    public int $id;
    public int $parent_id;
    public string $title;
    public array $children;

    public function __construct(array $data, string $locale)
    {
        $this->id = $data['id'];
        $this->title = $data['translations'][$locale]['title'] ?? $data['title'];
        $this->parent_id = $data['parent_id'];
        $this->children = array_map(
            fn($child) => new CategoryTreeDto($child, $locale),
            $data['children'] ?? []
        );
    }

}
