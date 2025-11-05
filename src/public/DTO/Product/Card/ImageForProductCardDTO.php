<?php
declare(strict_types=1);

namespace Vvintage\Public\DTO\Product\Card;

final class ImageForProductCardDTO
{
    public function __construct(
        public ?string $filename,
        public ?string $alt
    )
    {}
}

