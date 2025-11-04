<?php
declare(strict_types=1);

namespace Vvintage\DTO\Admin\Product;

final class ProductAdminListDTO
{
    public function __construct(
        public int $id,
        public string $title,
        public string $brand_title,
        public string $category_title,
        public int $price,
        public ?string $url,
        public string $status,
        public string $edit_time,
        public ?string $image_filename,
    )
    {}
}

