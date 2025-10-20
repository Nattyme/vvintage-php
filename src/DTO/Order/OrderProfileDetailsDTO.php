<?php
declare(strict_types=1);

namespace Vvintage\DTO\Order;

final class OrderDetailsDTO
{

    private function __construct(
        public ?int $id,
        public string $name,
        public string $surname,
        public string $email,
        public string $phone,
        public string $address,
        public \DateTime $datetime,
        public string $status,
        public bool $paid,
        public array $cart,
        public int $price,
        public string $tracking_number,
        public string $canceled_reason,
        public string $comment,
        public string $payment_type,
        public int $user_id
    ){}

}