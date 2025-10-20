<?php
declare(strict_types=1);

namespace Vvintage\DTO\Order;

final class OrderProfileSummaryDTO
{
    public function __construct(
      public ?int $id,
      public string $formatted_date,
      public string $status,
      public bool $paid,
      public int $price
    ){}

}