<?php
declare(strict_types=1);

namespace Vvintage\Public\DTO\Cart;
use Vvintage\Models\Product\Product;

final class CartItemDTO 
{
    public function __construct(
        public int $id,

        public ?string $slug,
        public string $title,
        public ?int $price,

        public ?string $image_filename,
        public ?string $image_alt
    )
    {}
}

