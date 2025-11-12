<?php
declare(strict_types=1);

namespace Vvintage\Admin\DTO\Product;
use Vvintage\Admin\DTO\Category\CategoryForProductDTO;
use Vvintage\Admin\DTO\Brand\BrandForProductDTO;
use Vvintage\Models\Product\Product;

final readonly class ProductDTO 
{
    public int $id;
    public int $category_id;
    public ?string $category_title;
    public ?CategoryForProductDTO $categoryDTO;

    public int $brand_id;
    public ?string $brand_title;
    public ?BrandForProductDTO $brandDTO;

    public string $slug;
    public string $title;
    public string $description;
    public int $price;
    public string $status;
    public string $sku;
    public int $stock;
    public string $currentLang; 
    public string $edit_time;
    public string $url;
    public ?array $images;
    public ?int $imagesTotal;
    public array $translations;


    public function __construct(Product $product)
    {
        $this->id = (int) ($product->getId() ?? 0);

        $this->category_id = (int) ($product->getCategoryId() ?? 0);
        $this->categoryDTO = new CategoryForProductDTO($product->getCategory()) ?? null;
        $this->category_title = $this->categoryDTO->title ?? null;

        $this->brand_id = (int) ($product->getBrandId() ?? 0);
        $this->brandDTO = new BrandForProductDTO($product->getBrand()) ?? null;
        $this->brand_title = $this->brandDTO->title ?? null;
     
        $this->slug = (string) ($product->getSlug() ?? '');
        $this->title = (string) ($product->getTitle() ?? '');
        $this->description = (string) ($product->getDescription() ?? '');
        $this->translations = $product->getCurrentTranslations() ?? [];
        $this->price = (int) ($product->getPrice() ?? '');
        $this->status = (string) ($product->getStatus() ?? '');
        
        $this->sku = (string) ($product->getSku() ?? '');
        $this->url = (string) ($product->getUrl() ?? '');
        $this->stock = (int) ($product->getStock() ?? 0);
        $this->edit_time = (string) ($product->getEditTime() ?? '');
        $this->images = $product->getImages();
        $this->currentLang = (string) ($product->getCurrentLang() ?? 'ru'); // локаль по умолчанию
    }

    public function setAmount(int $data): void 
    {
      $this->amount =  $data;
    }
}
