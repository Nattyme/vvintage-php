<?php
declare(strict_types=1);

namespace Vvintage\Public\DTO\Product\Page;

final class ProductPageImageDTO
{
    public function __construct(
        public ?int $id,
        public ?int $product_id,
        public ?string $filename,
        public ?int $image_order,
        public ?string $alt
    )
    {}
}

