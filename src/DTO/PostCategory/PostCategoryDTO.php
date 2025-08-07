<?php
declare(strict_types=1);

namespace Vvintage\DTO\PostCategory;

final class PostCategoryDTO
{
    public int $id;
    public int $parent_id;
    public string $title;
    public string $slug;
    public string $image;
    public array $translations;

    public function __construct(array $data)
    {
        $this->id = (int) ($data['id'] ?? 0);
        $this->parent_id = (int) ($data['parent_id'] ?? 0);
        $this->title = (string) ($data['title'] ?? '');
        $this->slug = (string) ($data['slug'] ?? '');
        $this->image = (string) ($data['image'] ?? '');
        $this->translations = is_array($data['translations'] ?? null) ? $data['translations'] : [];
    }
}
