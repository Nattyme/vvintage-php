<?php
declare(strict_types=1);

namespace Vvintage\DTO\Product;
use Vvintage\DTO\Product\ProductDTO;
use Vvintage\DTO\Category\CategoryForProductDTO;
use Vvintage\DTO\Brand\BrandForProductDTO;
use Vvintage\Models\Product\Product;

final class ProductPageDTO 
{
    public function __construct(
      public int $id,
      public int $category_id,
      public ?int $category_parent_id,
      public ?string $category_title,

      public int $brand_id,
      public ?string $brand_title,

      public string $slug,
      public string $title,
      public string $description,
      public int $price,
      public string $edit_time,

      public ?array $images
    )
    {}

    // public function setAmount(int $data): void 
    // {
    //   $this->amount =  $data;
    // }
}
      // $this->id = (int) ($product->getId() ?? 0);

      //   $this->category_id = (int) ($product->getCategoryId() ?? 0);
      //   $this->categoryDTO = new CategoryForProductDTO($product->getCategory()) ?? null;
      //   $this->category_title = $this->categoryDTO->title ?? null;

      //   $this->brand_id = (int) ($product->getBrandId() ?? 0);
      //   $this->brandDTO = new BrandForProductDTO($product->getBrand()) ?? null;
      //   $this->brand_title = $this->brandDTO->title ?? null;

      //   $this->slug = (string) ($product->getSlug() ?? '');
      //   $this->title = (string) ($product->getTitle() ?? '');
      //   $this->description = (string) ($product->getDescription() ?? '');
      //   $this->price = (int) ($product->getPrice() ?? '');
      //   $this->status = (string) ($product->getStatus() ?? '');
        
      //   $this->sku = (string) ($product->getSku() ?? '');
      //   $this->stock = (int) ($product->getStock() ?? 0);
      //   $this->edit_time = (string) ($product->getEditTime() ?? '');
      //   $this->currentLang = (string) ($product->getCurrentLang() ?? 'ru'); // локаль по умолчанию