<?php
declare(strict_types=1);

namespace Vvintage\DTO\Order;

final class OrderProfileDetailsDTO
{

    public function __construct(
        public ?int $id,
        public string $name,
        public string $surname,
        public string $email,
        public string $phone,
        public string $address,
        public string $formatted_date,
        public string $status,
        public bool $paid,
        // public array $cart,
        public int $price,
        public ?string $tracking_number,
        public ?string $canceled_reason,
        public ?string $comment,
    ){}

}