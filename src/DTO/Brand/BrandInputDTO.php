<?php
declare(strict_types=1);

namespace Vvintage\DTO\Brand;

final class BrandInputDTO 
{
    public function __construct(
      public ?int $id,   
      public string $title,
      public string $description,
      public ?string $image
    )
    {}

    public function toArray(): array
    {
      return get_object_vars($this);
    }
}
