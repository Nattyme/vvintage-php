<?php
declare(strict_types=1);

namespace Vvintage\DTO\Admin\Brand;
use Vvintage\Models\Brand\Brand;

final class BrandTranslationInputDTO 
{
    public function __construct(
      public int $brand_id,
      public string $locale,
      public string $title,
      public string $description,
      public string $meta_title,
      public string $meta_description
    )
    {}

    public function toArray (): array
    {
      return get_object_vars($this);
    }

}
