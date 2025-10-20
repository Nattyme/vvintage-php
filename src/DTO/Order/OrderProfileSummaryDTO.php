<?php
declare(strict_types=1);

namespace Vvintage\DTO\Order;

final class OrderProfileSummaryDTO
{
    public function __construct(
      public readonly ?int $id,
      public readonly string $formatted_date,
      public readonly string $status,
      public readonly bool $paid,
      public readonly int $price
    ){}

}