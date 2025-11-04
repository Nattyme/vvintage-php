<?php
declare(strict_types=1);

namespace Vvintage\public\DTO\Order;

final class OrderProfileDetailsDTO
{

    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly string $surname,
        public readonly string $email,
        public readonly string $phone,
        public readonly string $address,
        public readonly string $formatted_date,
        public readonly string $status,
        public readonly bool $paid,
        public array $cart,
        public readonly int $price,
        public readonly ?string $tracking_number,
        public readonly ?string $canceled_reason,
        public readonly ?string $comment,
        public readonly ?int $user_id,
    ){}

}