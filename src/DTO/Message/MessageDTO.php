<?php
declare(strict_types=1);

namespace Vvintage\DTO\Message;

final class MessageDTO
{
    private int $id;
    private string $email;
    private ?string $name;
    private ?string $message;
    private ?string $phone;
    private ?string $datetime;
    private ?string $status;
    private ?int $user_id;

    public function __construct(array $data)
    {
        $this->id = (int) ($data['id'] ?? 0);
        $this->email = (string) ($data['email'] ?? '');
        $this->name = (string) ($data['name'] ?? '');
        $this->message = (string) ($data['message'] ?? '');
        $this->phone = (string) ($data['phone'] ?? '');
        $this->datetime = (string) ($data['datetime'] ?? '');
        $this->status = (string) ($data['status'] ?? '');
        $this->user_id = (int) ($data['user_id'] ?? 0);
    }
}
