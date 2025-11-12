<?php
declare(strict_types=1);

namespace Vvintage\Public\DTO\Brand;
use Vvintage\Models\Brand\Brand;

final readonly class BrandForProductDTO
{
    public function __construct(
      public int $id,
      public ?string $title
    )
    {}

}
