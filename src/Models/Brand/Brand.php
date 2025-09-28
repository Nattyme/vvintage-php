<?php
declare(strict_types=1);

namespace Vvintage\Models\Brand;
use Vvintage\DTO\Brand\BrandDTO;
use Vvintage\Traits\HasTranslations;
;

final class Brand
{   
    use HasTranslations;

    private int $id;
    private string $title;
    private ?string $image;

    private array $translations = [];
    // private string $currentLocale = 'ru';

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
        // $brand->currentLocale = (string) ($data['locale'] ?? 'ru');
        
        return $brand;
    }

    public function setTranslations(array $data): void 
    {
      $this->translations = $data;
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

        return $this->description;
    }


    public function getSeoTitle(?string $locale = null): string {
        if ($locale) {
          return $this->translations['meta_title'] ?? '';
        }
        return $this->title;
    }

    public function getSeoDescription(?string $locale = null): string {
        if ($locale) {
          return $this->translations['meta_description'] ?? '';
        }
         return $this->description;
    }



}
