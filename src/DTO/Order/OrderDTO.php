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

    private function __construct(){}

     // Фабричный метод от формы
    public static function fromForm(array $data, array $cart, int $totalPrice, int $userId): self
    {
        return new self(
            trim($data['name'] ?? ''),
            trim($data['surname'] ?? ''),
            filter_var(trim($data['email'] ?? ''), FILTER_VALIDATE_EMAIL) ?: '',
            trim($data['phone'] ?? ''),
            trim($data['address'] ?? ''),
            new \DateTime(),
            'new',
            false,
            $cart,
            $totalPrice,
            $userId
        );
    }

    // Фабричный метод только корзина
    public static function fromCartOnly(array $cart): self
    {
        return new self(
            '', '', '', '', '',
            new \DateTime(),
            'new',
            false,
            $cart,
            0,
            0
        );
    }

    // Фабричный метод из базы
    public static function fromDatabase(array $row): self
    {
        return new self(
            $row['name'],
            $row['surname'],
            $row['email'],
            $row['phone'],
            $row['address'],
            new \DateTime($row['datetime']),
            $row['status'],
            (bool) $row['paid'],
            json_decode($row['cart'], true) ?? [],
            (int) $row['price'],
            (int) $row['user_id']
        );
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