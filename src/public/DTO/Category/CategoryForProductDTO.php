<?php
declare(strict_types=1);

namespace Vvintage\public\DTO\Category;
use Vvintage\Models\Category\Category;

final class CategoryForProductDTO
{
    public function __construct(
        public int $id,
        public string $title,
        public ?int $parent_id
    )
    {}

}
