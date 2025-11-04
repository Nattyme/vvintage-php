<?php
declare(strict_types=1);

namespace Vvintage\admin\DTO\Brand;
use Vvintage\Models\Brand\Brand;

final class BrandForAdminListDTO 
{
    public function __construct(
      public int $id,
      public string $title,
      public string $description
    )
    {}

}
