<?php
declare(strict_types=1);

namespace Vvintage\DTO\Message;

final class MessageDTO
{
    public ?int $id;
    public ?string $email;
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
        $dto->id = null;
        $email = filter_var(trim($data['email'] ?? ''), FILTER_VALIDATE_EMAIL);
        $dto->email = $email ?: null;
        $dto->name = trim($data['name'] ?? '') ?: null;
        $dto->message = trim($data['message'] ?? '') ?: null;
        $dto->phone = trim($data['phone'] ?? '') ?: null;
        $dto->datetime = new \DateTime();
        $dto->status = trim($data['status'] ?? 'new');
        $dto->user_id = isset($data['user_id']) ? (int) $data['user_id'] : null;

        return $dto;
    }

    public static function fromDatabase(array $row): self
    {
        $dto = new self();
        $dto->id = (int) $row['id'];
        $dto->email = $row['email'];
        $dto->name = $row['name'];
        $dto->message = $row['message'];
        $dto->phone = $row['phone'];
        $dto->datetime = new \DateTime($row['datetime']);
        $dto->status = $row['status'];
        $dto->user_id = $row['user_id'] ? (int) $row['user_id'] : null;

        return $dto;
    }

    public function isValid(): bool
    {
        return !empty($this->name)
            && !empty($this->email)
            && !empty($this->phone)
            && !empty($this->message);
    }
}
