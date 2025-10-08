<?php
declare(strict_types=1);

namespace Vvintage\DTO\Product;
use Vvintage\DTO\Product\ProductDTO;
use Vvintage\DTO\Category\CategoryOutputDTOfromModel;
use Vvintage\DTO\Brand\BrandOutputDTOfromModel;
use Vvintage\Models\Product\Product;

final class ProductOutputDTOfromModel 
{
    public int $id;
    public int $category_id;
    public ?string $category_title;
    public ?CategoryOutputDTOfromModel $categoryDTO;

    public int $brand_id;
    public ?string $brand_title;
    public ?BrandOutputDTOfromModel $brandDTO;

    public string $slug;
    public string $title;
    public string $description;
    public int $price;
    public string $url;
    public string $status;
    public string $sku;
    public int $stock;
    public ?\Datetime $datetime;
    public string $edit_time;

    public ?array $images;
    public ?int $imagesTotal;
    

    public array $translations;
    public string $currentLang; 


    public function __construct(Product $product)
    {
        $this->id = (int) ($product->getId() ?? 0);

        $this->category_id = (int) ($product->getCategoryId() ?? 0);
        $this->categoryDTO = new CategoryOutputDTOfromModel($product->getCategory()) ?? null;
        $this->category_title = $this->categoryDTO->title ?? null;

        $this->brand_id = (int) ($product->getBrandId() ?? 0);
        $this->brandDTO = new BrandOutputDTOfromModel($product->getBrand()) ?? null;
        $this->brand_title = $this->brandDTO->title ?? null;
      // $this->translations = $product->getCurrentTranslations() ?? [];

        $this->slug = (string) ($product->getSlug() ?? '');
        $this->title = (string) ($product->getTitle() ?? '');
        $this->description = (string) ($product->getDescription() ?? '');
        $this->price = (int) ($product->getPrice() ?? '');
        $this->url = (string) ($product->getUrl() ?? '');
        $this->status = (string) ($product->getStatus() ?? '');
        
        $this->sku = (string) ($product->getSku() ?? '');
        $this->stock = (int) ($product->getStock() ?? 0);
        $this->datetime = $product->getDatetime();
        $this->edit_time = (string) ($product->getEditTime() ?? '');

        $imagesRaw = $product->getImages() ?? null;
   
        if (is_array($imagesRaw)) {
            $this->images = $imagesRaw;
        } elseif (is_string($imagesRaw)) {
            $this->images = array_filter(explode(',', $imagesRaw));
        } else {
            $this->images = null;
        }

        $this->imagesTotal = isset($this->images) ? count($this->images) : null;
        $this->currentLang = (string) ($product->getCurrentLang() ?? 'ru'); // локаль по умолчанию
    }

    public function setAmount(int $data): void 
    {
      $this->amount =  $data;
    }
}
