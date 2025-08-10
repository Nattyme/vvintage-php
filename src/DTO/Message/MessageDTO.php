<?php
declare(strict_types=1);

namespace Vvintage\DTO\Message;

final class MessageDTO
{
    public int $id;
    public string $email;
    public ?string $name;
    public ?string $message;
    public ?string $phone;
    public \DateTime $datetime;
    public ?string $status;
    public ?int $user_id;

    private function __construct(){}

    public static function fromForm(array $data): self
    {
        $dto = new self();
        $dto->email = filter_var(trim($data['email'] ?? ''), FILTER_VALIDATE_EMAIL) ?: '';;
        $dto->name = trim($data['name'] ?? '');
        $dto->message = trim($data['message'] ?? '');
        $dto->phone = trim($data['phone'] ?? '');
        $dto->datetime = new \DateTime();
        $dto->status = trim($data['status'] ?? 'new');
        $dto->user_id = (int) ($data['user_id'] ?? 0);

        return $dto;
    }

    public static function fromDatabase(array $cart): self
    {
        $dto = new self();
        $dto->id = $row['id'];
        $dto->email = $row['email'];
        $dto->name = $row['name'];
        $dto->message = $row['message'];
        $dto->phone = $row['phone'];
        $dto->datetime = new \DateTime($row['datetime']);
        $dto->status = $row['status'];
        $dto->user_id = $row['user_id'];

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
