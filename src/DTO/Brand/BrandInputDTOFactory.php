<?php
declare(strict_types=1);

namespace Vvintage\DTO\Brand;

use Vvintage\Models\Brand\Brand;
use Vvintage\DTO\Brand\BrandInputDTO;

final class BrandInputDTOFactory
{
    public function createFromArray(array $data, ?int $id): BrandInputDTO
    {
      return new BrandInputDTO(
          id: (int) ($id ?? 0),
          title: (string) ($data['title'] ?? null),
          description: (string) ($data['description'] ?? null),
          image: (string) ($data['image'] ?? null),
      );
    }

}
