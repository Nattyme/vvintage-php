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
        $brand->seoTitle = (string) ($data['seo_title'] ?? '');
        $brand->seoDescription = (string) ($data['seo_description'] ?? '');
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
}
