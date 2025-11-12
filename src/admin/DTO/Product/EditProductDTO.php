<?php
declare(strict_types=1);

namespace Vvintage\Admin\DTO\Product;

use Vvintage\Admin\DTO\Category\CategoryForProductDTO;
use Vvintage\Admin\DTO\Brand\BrandForProductDTO;

final readonly class EditProductDTO 
{

    public function __construct(
      public int $id,
      public int $category_id,
      public string $category_title,
      public string $category_parent_id,

      public int $brand_id,
      public string $brand_title,

      public string $slug,
      public string $title,
      public string $description,

      public int $price,
      public string $status,
      public string $sku,
      public int $stock,

      public string $edit_time,
      public string $url,
      public ?array $images,

      public array $translations
    )
    {}

}
