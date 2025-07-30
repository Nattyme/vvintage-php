<?php
declare(strict_types=1);

namespace Vvintage\Models\Category;

use Vvintage\DTO\Category\CategoryDTO;

final class Category
{
    private int $id;
    private string $title;
    private int $parent_id;
    private string $image;
    private array $translations;
    private string $seoTitle;
    private string $seoDescription;

    private function __construct() {} // запрет внешнего new

    public static function fromDTO(CategoryDTO $dto): self
    {
        $category = new self();

        $category->id = $dto->id;
        $category->title = $dto->title;
        $category->parent_id = $dto->parent_id;
        $category->image = $dto->image;
        $category->translations = $dto->translations;
        $category->seoTitle = $dto->seoTitle;
        $category->seoDescription = $dto->seoDescription;

        return $category;
    }

    public static function fromArray(array $data): self
    {
        $category = new self();

        $category->id = (int) ($data['id'] ?? 0);
        $category->title = (string) ($data['title'] ?? '');
        $category->parent_id = (int) ($data['parent_id'] ?? 0);
        $category->image = (string) ($data['image'] ?? '');
        $category->translations = $data['translations'] ?? [];
        $category->seoTitle = (string) ($data['seo_title'] ?? '');
        $category->seoDescription = (string) ($data['seo_description'] ?? '');

        return $category;
    }

    // Геттеры
    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(string $locale = 'ru'): string
    {
        return $this->translations[$locale]['title'] ?? $this->translations['ru']['title'] ?? $this->title;
    }

    public function getSeoTitle(): string
    {
        return $this->seoTitle;
    }

    public function getSeoDescription(): string
    {
        return $this->seoDescription;
    }

    public function getParentId(): int
    {
        return $this->parent_id;
    }

    public function getImage(): string
    {
        return $this->image;
    }
}
