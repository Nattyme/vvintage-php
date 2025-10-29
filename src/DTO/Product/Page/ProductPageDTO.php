<?php
declare(strict_types=1);

namespace Vvintage\DTO\Product\Page;

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
}