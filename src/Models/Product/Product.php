<?php

declare(strict_types=1);

namespace Vvintage\Models\Product;

/** DTO */
use Vvintage\DTO\Product\ProductDTO;
use Vvintage\DTO\Product\ProductImageDTO;
use Vvintage\DTO\Category\CategoryDTO;
use Vvintage\DTO\Brand\BrandDTO;

/** Модели */
use Vvintage\Models\Category\Category;
use Vvintage\Models\Brand\Brand;

require_once ROOT . "./libs/functions.php";

class Product
{
    private int $id;

    private Category $category;  
    private Brand $brand;  
    
    private string $slug;
    private string $title;
    private string $description;
    private string $price;
    private string $url;
    private string $sku;
    private int $stock;
    private \Datetime $datetime;
    private array $translations;
    private string $currentLocale = 'ru';
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
      
      $product->category = Category::fromDTO($dto->categoryDTO);
      $product->brand = Brand::fromDTO($dto->brandDTO);

      $product->slug = $dto->slug;
      $product->title = $dto->title;
      $product->description = $dto->description;
      $product->price = $dto->price;
      $product->url = $dto->url;
      $product->sku = $dto->sku;
      $product->stock = $dto->stock;
      $product->datetime = new \Datetime ();
      $product->translations = $dto->translations;
      $product->images = $dto->images;
      

      return $product;
    }

    public static function fromArray(array $data): self
    {
      $product = new self();

      $product->id = (int) ($data['id'] ?? 0);

      $product->slug = (string) ($data['slug'] ?? '');
      $product->title = (string) ($data['title'] ?? '');
      $product->description = (string) ($data['description'] ?? '');
      $product->price = (string) ($data['price'] ?? '');
      $product->url = (string) ($data['url'] ?? '');
      $product->sku =  (string) ($data['sku'] ?? '');
      $product->stock =  (int) ($data['stock'] ?? 0);
      $product->datetime =  (string) ($data['datetime'] ?? '');

      $product->images = $data['images'] ?? [];

      $product->translations = $data['translations'] ?? [];
      $product->currentLocale = (string) ($data['locale'] ?? 'ru');

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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getBrandId(): string
    {
        return $this->brand->getId();
    }

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

    public function getContent(): string
    {
        return $this->description;
    }

    public function getDatetime(): \Datetime
    {
        return $this->datetime;
    }

    public function getCategory(): Category
    {
      return $this->category;
    }

    public function getCategoryTitle(): string {
        return $this->category->getTitle();
    }

    public function getCurrentLocale(): string 
    {
      return $this->currentLocale;
    }

    public function getTranslations(): array 
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
}
