<?php
declare(strict_types=1);

namespace Vvintage\Public\DTO\Order;

final readonly class OrderDTO
{
    public ?int $id;
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
    public string $tracking_number;
    public string $canceled_reason;
    public string $comment;
    public string $payment_type;
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
        $dto->tracking_number = trim($data['tracking_number'] ?? '');
        $dto->canceled_reason = trim($data['canceled_reason'] ?? '');
        $dto->comment = trim($data['comment'] ?? '');
        $dto->payment_type = trim($data['payment_type'] ?? '');
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
        $dto->tracking_number = '';
        $dto->canceled_reason = '';
        $dto->comment = '';
        $dto->payment_type = '';
        $dto->user_id = 0;

        return $dto;
    }

    // Фабричный метод из базы
    public static function fromDatabase(array $row): self
    {
        $dto = new self();
        $dto->id = $row['id'];
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
        $dto->tracking_number = $row['tracking_number'];
        $dto->canceled_reason = $row['canceled_reason'];
        $dto->comment = $row['comment'];
        $dto->payment_type = $row['payment_type'];
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