<?php
declare(strict_types=1);

namespace Vvintage\Public\DTO\PostCategory;

class PostCategoryDTO
{
    public ?int $parent_id;
    public string $title;
    public string $slug;
    public string $image;
    public array $translations;

    public function __construct(array $data)
    {
        $this->parent_id = $data['parent_id'] ? (int) $data['parent_id'] :  null;
        $this->title = (string) ($data['title'] ?? '');
        $this->slug = (string) ($data['slug'] ?? '');
        $this->image = (string) ($data['image'] ?? '');
        $this->translations = is_array($data['translations'] ?? null) ? $data['translations'] : [];
    }
}
