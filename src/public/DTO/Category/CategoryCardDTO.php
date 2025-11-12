<?php
declare(strict_types=1);

namespace Vvintage\Public\DTO\Category;
use Vvintage\Public\DTO\Category;

final readonly class CategoryCardDTO 
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
