<?php
declare(strict_types=1);

namespace Vvintage\DTO\Brand;

final class BrandInputDTO extends BrandDTO
{
    public ?int $id;
    public function __construct(array $data)
    {
      parent::__construct($data);
      $this->id = (int)($data['id'] ?? 0);
    }

}
