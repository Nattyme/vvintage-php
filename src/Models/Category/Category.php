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

    private array $translations = [];
    private string $seoTitle = '';
    private string $seoDescription = '';
    private string $currentLocale = 'ru';

    private function __construct() {}

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
        $category->currentLocale = (string) ($data['locale'] ?? 'ru');

        return $category;
    }

    // Получение названия в нужной локали, иначе fallback title
    public function getTitle(?string $locale = null): string
    {
        $locale = $locale ?? $this->currentLocale;

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

    public function getSeoTitle(?string $locale = null): string
    {
        $locale = $locale ?? $this->currentLocale;

        return $this->translations[$locale]['seo_title']
            ?? $this->seoTitle;
    }

    public function getSeoDescription(?string $locale = null): string
    {
        $locale = $locale ?? $this->currentLocale;

        return $this->translations[$locale]['seo_description']
            ?? $this->seoDescription;
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

    // Позволяет задать локаль один раз, чтобы не передавать её в каждый геттер.
    public function setCurrentLocale(string $locale): void
    {
        $this->currentLocale = $locale;
    }
}
