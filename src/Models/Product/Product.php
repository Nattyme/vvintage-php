<?php

declare(strict_types=1);

namespace Vvintage\Models\Product;

/** DTO */
use Vvintage\DTO\Product\ProductDTO;
use Vvintage\DTO\Product\ProductImageDTO;
use Vvintage\DTO\Category\CategoryOutputDTO;
use Vvintage\DTO\Brand\BrandDTO;

/** Модели */
use Vvintage\Models\Category\Category;
use Vvintage\Models\Brand\Brand;

require_once ROOT . "./libs/functions.php";

class Product
{
    private int $id;

    private Category $category;  
    private int $category_id;  
    private Brand $brand; 
    private int $brand_id;
    
    private string $slug;
    private string $title;
    private string $description;
    private string $price;
    private string $url;
    private string $status;
    private string $sku;
    private int $stock;
    private \Datetime $datetime;
    private string $edit_time;
    private array $translations;
    private string $currentLang = 'ru';
    private ?array $images;      // массив изображений

    const PRODUCT_CONDITIONS = [
        'new',
        'withouttags',
        'good',
        'usedabit',
        'hasdeffect',
    ];


    // <option value="new">{{ __('condition.' . $key) }}</option>
    // Если 

    private function __construct() {}

    public static function fromDTO(ProductDTO $dto): self
    {
    
      $product = new self();

      $product->id = $dto->id;
      
      $product->category = Category::fromOutputDTO($dto->categoryDTO);
      $product->brand = Brand::fromDTO($dto->brandDTO);

      $product->slug = $dto->slug;
      $product->title = $dto->title;
      $product->description = $dto->description;
      $product->price = $dto->price;
      $product->url = $dto->url;
      $product->status = $dto->status;   
      $product->sku = $dto->sku;
      $product->stock = $dto->stock;
      $product->datetime = new \Datetime ();
      $product->edit_time = $dto->edit_time;
      $product->translations = $dto->translations;
      $product->currentLang = $dto->locale ?? 'ru';
      // $product->images = $dto->images;
      

      return $product;
    }

    public static function fromArray(array $data): self
    {
      $product = new self();
 
      $product->id = (int) ($data['id'] ?? 0);
      $product->category_id = (int) ($data['category_id'] ?? 0);
      $product->brand_id = (int) ($data['brand_id'] ?? 0);
      $product->translations = $data['translations'] ?? [];

      $product->slug = (string) ($data['slug'] ?? '');

      $product->title = (string) ($data['translations']['title'] ?? $data['title'] ?? '');
      $product->description = (string) ($data['translations']['description'] ?? $data['description'] ?? '');

      $product->price = (string) ($data['price'] ?? '');
      $product->url = (string) ($data['url'] ?? '');
      $product->status = (string) ($data['status'] ?? '');
      $product->sku =  (string) ($data['sku'] ?? '');
      $product->stock =  (int) ($data['stock'] ?? 0);

      $product->datetime = !empty($data['datetime'])
            ? (is_numeric($data['datetime'])
                ? (new \DateTime())->setTimestamp((int)$data['datetime'])
                : new \DateTime($data['datetime']))
            : new \DateTime();

      $product->edit_time =  (string) ($data['edit_time'] ?? '');

      // $product->images = $data['images'] ?? [];
      $product->currentLang = (string) ($data['locale'] ?? 'ru');

      return $product;
    }

    public function getRelated(): array
    {
        return get_related_products($this->title, $this->brand->getTitle(), $this->category);
    }


    /**
     * Getters
    */
    public function getId(): int
    {
        return $this->id;
    }

    public function getCategoryId(): int
    {
       return $this->category_id;
    }

     public function getCategory(): Category
    {
      return $this->category;
    }
    
    public function getBrand(): Brand
    {
      return $this->brand;
    }

    public function getBrandId(): int
    {
       return $this->brand_id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }


    // public function getBrandId(): int
    // {
    //     return $this->brand->getId();
    // }

    public function getBrandTitle(): string
    {
        return $this->brand->getTitle();
    }

    public function getUrl(): string
    {
      return $this->url;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

   
    public function getDatetime(): \Datetime
    {
        return $this->datetime;
    }

    public function getEditTime(): string
    {
        return $this->edit_time;
    }

   

    public function getCategoryTitle(): string {
        return $this->category->getTitle();
    }

    public function getCurrentLang(): string 
    {
      return $this->currentLang;
    }
      
    public function getTranslations(): ?array
    {
      return $this->translations;
    }

    public function getImages(): array
    {
        return $this->images ?? [];
    }

    public function getSku(): string 
    {
      return $this->sku;
    }

    public function getSlug(): string
    {
      return $this->slug;
    }

    public function getStock(): int
    {
      return $this->stock;
    }

    public function getStatus(): string
    {
      return $this->status;
    }

    public function getTranslatedTitle(?string $currentLang = null): string 
    {
        $this->currentLang = $currentLang ?? $this->currentLang;

        return $this->translations['title'];
    }

    public function getTranslatedDescription(?string $locale = null): string 
    {
        $this->currentLang = $currentLang ?? $this->currentLang;

        return $this->translations['description'];
    }


    public function getSeoTitle(?string $locale = null): string {
        $locale = $locale ?? $this->currentLocale;
        return $this->translations[$locale]['meta_title'] ?? $this->title;
    }

    public function getSeoDescription(?string $locale = null): string {
        $locale = $locale ?? $this->currentLocale;
        return $this->translations[$locale]['meta_description'] ?? $this->title;
    }

    public function setTranslations(array $translations): void 
    {
      $this->translations = $translations;
    }

    public function setCategory(Category $category): void
    {
      $this->category = $category;
    }

    public function setBrand(Brand $brand): void
    {
      $this->brand = $brand;
    }

    public function setImages(array $images): void 
    {
      $this->images = $images;
    }

    public function getCurrentTranslations(): array
    {
      return $this->translations;
    }

    public function setCurrentLang(string $currentLang): void 
    {
      $this->currentLang = $currentLang;
    }

  
}
