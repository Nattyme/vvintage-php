<?php
declare(strict_types=1);

namespace Vvintage\Models\PostCategory;

use Vvintage\DTO\PostCategory\PostCategoryDTO;
use Vvintage\DTO\PostCategory\PostCategoryInputDTO;
use Vvintage\DTO\PostCategory\PostCategoryOutputDTO;

final class PostCategory
{
    private ?int $id;
    private ?int $parent_id;
    private string $slug;
    private string $title;
    private string $image;
    private ?string $description;

    private array $translations = [];

    private function __construct() {}


    public static function fromArray(array $data): self
    {
        $category = new self();

        $category->id = (int) ($data['id'] ?? 0);
        $category->title = (string) ($data['title'] ?? '');
        $category->parent_id = $data['parent_id'] ?? null;
        $category->slug = (string) ($data['slug'] ?? '');
        $category->image = (string) ($data['image'] ?? '');
        $category->translations = $data['translations'] ?? [];

        return $category;
    }

    public function getTitle(?string $locale = null): string
    {
        $locale = $locale ?? null;

        if($locale) {
          return $this->translations[$locale]['title'];
        }
        return $this->translations['ru']['title']
            ?? $this->title;
    }

    // Получение названия в нужной локали, иначе fallback description
    public function getDescription(?string $locale = null): string
    {
      $locale = $locale ?? null;

      if($locale) {
        return $this->translations[$locale]['description'];
      }
      return $this->translations['ru']['description']
          ?? $this->description;
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function getParentId(): ?int
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

    // Позволяет задать локаль один раз, чтобы не передавать её в каждый геттер.
    public function setCurrentLocale(string $locale): void
    {
        $this->currentLocale = $locale;
    }


    public function getTranslatedTitle(?string $locale = null): string 
    {
        $locale = $locale ?? $this->currentLocale;

        return $this->translations[$locale]['title'] ?? $this->title;
    }

    public function getTranslatedDescription(?string $locale = null): string 
    {
        $locale = $locale ?? $this->currentLocale;

        return ($this->translations[$locale]['description'] ?? $this->getDescription()) ?? '';
    }


    public function getSeoTitle(?string $locale = null): string {
        $locale = $locale ?? $this->currentLocale;
        return $this->translations[$locale]['meta_title'] ?? $this->title;
    }

    public function getSeoDescription(?string $locale = null): string {
        $locale = $locale ?? $this->currentLocale;
        return $this->translations[$locale]['meta_description'] ?? $this->title;
    }

    public function getSlug(): string 
    {
      return $this->slug;
    }

    public function setTranslations(array $translations): void 
    {
      $this->translations = $translations;
    }

    public function getTranslation(string $locale = null): array
    {
      if($locale) {
        return $this->translations[$locale] ?? $this->translations['ru'] ?? [];
      }
        return $this->translations ?? [];
    }

}
