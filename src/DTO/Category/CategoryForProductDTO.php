<?php
declare(strict_types=1);

namespace Vvintage\DTO\Category;
use Vvintage\Models\Category\Category;

final class CategoryForProductDTO
{
    public int $id;
    public string $title;
    public ?string $description;
    public ?int $parent_id;
    public ?string $slug;
    public ?string $image;
    public ?array $translations; // ['ru' => [...], 'en' => [...]

    public function __construct(Category $category)
    {
        $this->id = (int) ($category->getId() ?? 0);
        $this->translations = $category->getTranslations() ?? [];
        $this->title = (string) ($this->translations['title'] ?? '');
        $this->description = (string)($this->translations['description'] ?? '');
        $this->parent_id = (int) ($category->getParentId() ?? 0);
        $this->slug = (string) ($category->getSlug() ?? '');
        $this->image = (string) ($category->getImage() ?? '');
    }

}
