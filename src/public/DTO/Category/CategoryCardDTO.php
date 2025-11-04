<?php
declare(strict_types=1);

namespace Vvintage\public\DTO\Category;
use Vvintage\public\DTO\Category;

final class CategoryCardDTO 
{
    public function __construct(
        public int $id,
        public ?int $parent_id,
        public string $title,
        public string $slug,
        public string $image
    )
    {}

}
