<?php
declare(strict_types=1);

namespace Vvintage\Models\Brand;
use Vvintage\DTO\Brand\BrandDTO;

final class Brand
{
    private int $id;
    private string $title;
    private ?string $image;

    private array $translations = [];
    private string $currentLocale = 'ru';

    private function __construct() {}

    public static function fromDTO(BrandDTO $dto): self
    {
        $brand = new self();
        $brand->id = (int) $dto->id;
        $brand->title = (string) $dto->title;
        $brand->image = (string) $dto->image;

        $brand->translations = $dto->translations;
        
        return $brand;
    }

    public static function fromArray(array $data): self
    {
        $brand = new self();
        $brand->id = (int) ($data['id'] ?? 0);
        $brand->title = (string) ($data['title'] ?? '');
        $brand->image = (string) ($data['image'] ?? '');
        $brand->translations = $data['translations'] ?? [];
        $brand->currentLocale = (string) ($data['locale'] ?? 'ru');
        
        return $brand;
    }
    
    
    // Геттеры 
    public function getId(): int
    {
      return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getImage(): string
    {
      return $this->image;
    }

    public function getTranslations(): array
    {
      return $this->translations;
    }



    public function setLocale(string $locale): void
    {
        $this->currentLocale = $locale;
    }

    public function getLocale(): string
    {
        return $this->currentLocale;
    }

    public function getTranslation(string $locale = null): ?array
    {
        $locale = $locale ?? $this->currentLocale;
        return $this->translations[$locale] ?? null;
    }

    public function getTranslatedTitle(): string
    {
        return $this->getTranslation()['title'] ?? $this->title;
    }

    public function getTranslatedDescription(): string
    {
        return $this->getTranslation()['description'] ?? '';
    }

    public function getMetaTitle(): string
    {
        return $this->getTranslation()['meta_title'] ?? '';
    }

    public function getMetaDescription(): string
    {
        return $this->getTranslation()['meta_description'] ?? '';
    }

}
