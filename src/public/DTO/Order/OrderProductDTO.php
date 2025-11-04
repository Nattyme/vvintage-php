<?php
declare(strict_types=1);

namespace Vvintage\public\DTO\Order;

final class OrderProductDTO
{
    public function __construct(
      public readonly ?int $id,
      public readonly string $title,
      public readonly int $price,
      public readonly string $image,
      public readonly int $amount
    ){}
}