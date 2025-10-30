<?php
declare(strict_types=1);

namespace Vvintage\DTO\Admin\Category;
use Vvintage\DTO\Category\CategoryDTO;

final class CategoryInputDTO 
{
  public int $id;
    public string $title;
    public string $description;
    public int $parent_id;
    public ?string $slug;
    public ?string $image;
    // public array $translations; // ['ru' => [...], 'en' => [...]

    public function __construct(array $data)
    {
        $this->id = (int) ($data['id'] ?? 0);
        $this->title = (string) ($data['title'] ?? '');
        $this->description = (string) ($data['description'] ?? '');
        $this->parent_id = (int) ($data['parent_id'] ?? 0);
        $this->slug = (string) ($data['slug'] ?? null);
        $this->image = (string) ($data['image'] ?? null);
        // $this->translations = is_array($data['translations'] ?? null) ? $data['translations'] : [];
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'parent_id' => $this->parent_id,
            'slug' => $this->slug,
            'image' => $this->image,
        ];
    }

}

