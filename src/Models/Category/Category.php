<?php
declare(strict_types=1);

namespace Vvintage\Models\Category;

use Vvintage\DTO\Category\CategoryDTO;
use Vvintage\DTO\Admin\Category\CategoryInputDTO;
use Vvintage\DTO\Category\CategoryOutputDTO;


final class Category
{
    private int $id;
    private int $parent_id;
    private string $slug;
    private string $title;
    private string $image;
    private ?string $description;

    private ?array $translations = [];


    private function __construct() {}

    public static function fromArray(array $data): self
    {
        $category = new self();

        $category->id = (int) ($data['id'] ?? 0);
        $category->title = (string) ($data['title'] ?? '');
        $category->description = (string) ($data['description'] ?? '');
        $category->parent_id = (int) ($data['parent_id'] ?? 0);
        $category->slug = (string) ($data['slug'] ?? '');
        $category->image = (string) ($data['image'] ?? '');
        $category->translations = $data['translations'] ?? [];


        return $category;
    }


    // Получение названия в нужной локали, иначе fallback title
    public function getTitle(?string $locale = null): string
    {
        $locale = $locale ?? null;

        return $this->translations[$locale]['title']
            ?? $this->translations['ru']['title']
            ?? $this->title;
    }

    public function getDescription(?string $locale = null): string
    {
        $locale = $locale ?? $this->currentLocale;

        return $this->translations[$locale]['description']
            ?? $this->translations['ru']['description']
            ?? '';
    }

    public function getSlug(): string 
    {
      return $this->slug;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getParentId(): int
    {
        return $this->parent_id;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getAllTranslations(): array
    {
        return $this->translations;
    }

    public function getCurrentLocale(): string
    {
        return $this->currentLocale;
    }

    public function getTranslations(?string $locale = null): array
    {
        if ($locale) {
            return $this->translations[$locale] ?? [];
        }
        return $this->translations;
    }


    public function getTranslatedTitle(?string $locale = null): string 
    {
        if ($locale) {
            return $this->translations['title'] ?? '';
        }

        return $this->title;
    }

    public function getTranslatedDescription(?string $locale = null): string 
    {
        if ($locale) {
          return $this->translations['description'] ?? '';
        }

        return $this->description ?? '';
    }


    public function getSeoTitle(?string $locale = null): string {
        return $this->translations[$locale]['meta_title'] ?? $this->title;
    }

    public function getSeoDescription(?string $locale = null): ?string 
    {
        return $this->translations[$locale]['meta_description'] ?? $this->title;
    }

    // Позволяет задать локаль один раз, чтобы не передавать её в каждый геттер.
    public function setCurrentLocale(string $locale): void
    {
        $this->currentLocale = $locale;
    }

    public function setTranslations(array $translations): void 
    {
      $this->translations = $translations;
    }

    

}
