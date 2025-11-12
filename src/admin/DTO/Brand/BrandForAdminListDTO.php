<?php
declare(strict_types=1);

namespace Vvintage\Admin\DTO\Brand;
use Vvintage\Models\Brand\Brand;

final readonly class BrandForAdminListDTO 
{
    public function __construct(
      public int $id,
      public string $title,
      public string $description
    )
    {}

}
