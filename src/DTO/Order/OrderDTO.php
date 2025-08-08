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
        $dto = new self();
        $dto->name = trim($data['name'] ?? '');
        $dto->surname = trim($data['surname'] ?? '');
        $dto->email = filter_var(trim($data['email'] ?? ''), FILTER_VALIDATE_EMAIL) ?: '';
        $dto->phone = trim($data['phone'] ?? '');
        $dto->address = trim($data['address'] ?? '');
        $dto->datetime = new \DateTime();
        $dto->status = 'new';
        $dto->paid = false;
        $dto->cart = $cart;
        $dto->price = $totalPrice;
        $dto->user_id = $userId;

        return $dto;
    }


    // Фабричный метод только корзина
    public static function fromCartOnly(array $cart): self
    {
        $dto = new self();
        $dto->name = '';
        $dto->surname = '';
        $dto->email = '';
        $dto->phone = '';
        $dto->address = '';
        $dto->datetime = new \DateTime();
        $dto->status = 'new';
        $dto->paid = false;
        $dto->cart = $cart;
        $dto->price = 0;
        $dto->user_id = 0;

        return $dto;
    }

    // Фабричный метод из базы
    public static function fromDatabase(array $row): self
    {
        $dto = new self();
        $dto->name = $row['name'];
        $dto->surname = $row['surname'];
        $dto->email = $row['email'];
        $dto->phone = $row['phone'];
        $dto->address = $row['address'];
        $dto->datetime = new \DateTime($row['datetime']);
        $dto->status = $row['status'];
        $dto->paid = (bool) $row['paid'];
        $dto->cart = json_decode($row['cart'], true) ?? [];
        $dto->price = (int) $row['price'];
        $dto->user_id = (int) $row['user_id'];

        return $dto;
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