<?php
declare(strict_types=1);

namespace Vvintage\DTO\Product;
use Vvintage\Models\Product\Product;

final class ProductCardDTO
{
    public function __construct(
        public int $id,

        public int $category_id,
        public int $category_parent_id,
        public string $category_title,

        public int $brand_id,
        public string $brand_title,

        public ?string $slug,
        public string $title,
        public ?int $price,

        public ?string $image_filename,
        public ?string $image_alt
    )
    {}
}

