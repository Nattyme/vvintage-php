<?php
declare(strict_types=1);

namespace Vvintage\DTO\Order;

final class OrderDTO
{
    public string $name;
    public string $surname;
    public string $email;
    public string $phone;
    public string $address;
    public \DateTime $datetime;
    public string $status;
    public bool $paid;
    public array $cart;
    public int $price;
    public int $user_id;

    public function __construct(array $data, array $cart, int $totalPrice, int $userId)
    {
        $this->name = trim($data['name'] ?? '');
        $this->surname = trim($data['surname'] ?? '');
        $this->email = filter_var(trim($data['email'] ?? ''), FILTER_VALIDATE_EMAIL) ?: '';
        $this->phone = trim($data['phone'] ?? '');
        $this->address = trim($data['address'] ?? '');

        $this->datetime = new \DateTime();
        $this->status = 'new';
        $this->paid = false;

        $this->cart = is_array($cart ?? [])
            ? $cart
            : [];
        $this->price = (int) $totalPrice;
        $this->user_id = (int) $userId;
    }

    public function isValid(): bool
    {
        return $this->name !== ''
            && $this->surname !== ''
            && $this->email !== ''
            && $this->phone !== ''
            && $this->address !== '';
    }

}