<?php
declare(strict_types=1);

namespace Vvintage\Public\DTO\Category;

class CategoryDTO
{
    public int $id;
    public string $title;
    public int $parent_id;
    public string $slug;
    public string $image;
    public array $translations; // ['ru' => [...], 'en' => [...]

    public function __construct(array $data)
    {
        $this->id = (int) ($data['id'] ?? 0);
        $this->title = (string) ($data['title'] ?? '');
        $this->parent_id = (int) ($data['parent_id'] ?? 0);
        $this->slug = (string) ($data['slug'] ?? '');
        $this->image = (string) ($data['image'] ?? '');
        $this->translations = is_array($data['translations'] ?? null) ? $data['translations'] : [];
    }

}
