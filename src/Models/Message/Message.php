<?php
declare(strict_types=1);

namespace Vvintage\Models\Message;

use Vvintage\DTO\Message\MessageDTO;


final class Message
{   
    private int $id;
    private string $email;
    private ?string $name;
    private ?string $message;
    private ?string $phone;
    private \DateTime $datetime;
    private ?string $status;
    private ?int $user_id;

  

    private function __construct() {}
  

    public static function fromDTO(MessageDTO $dto): self
    {
        $message = new self();
        $message->id = (int) $dto->id;
        $message->email = (string) $dto->email;
        $message->name = (string) $dto->name;
        $message->message = (string) $dto->message;
        $message->phone = (string) $dto->phone;
        $message->datetime = $dto->datetime;
        $message->status = (string) $dto->status;
        $message->user_id = (int) $dto->user_id;
    
        
        return $message;
    }

    public static function fromArray(array $data): self
    {   
        $message = new self();

        $message->id = (int) ($data['id'] ?? 0);
        $message->email = (string) ($data['email'] ?? '');
        $message->name = (string) ($data['name'] ?? '');
        $message->message = (string) ($data['message'] ?? '');
        $message->phone = (string) ($data['phone'] ?? '');
        $datetimeString = $data['datetime'] ?? null;
        $message->datetime = $datetimeString ? new \DateTime($datetimeString) : new \DateTime();
        $message->status = (string) ($data['status'] ?? '');
        $message->user_id =  (int) ($data['user_id'] ?? 0);
    
        
        return $message;
    }
    
    
    // Геттеры 
    public function getId(): int
    {
      return $this->id;
    }

    public function getEmail(): string
    {
      return $this->email;
    }

    public function getName(): string
    {
      return $this->name;
    }

    public function getMessage(): string
    {
      return $this->message;
    }
    public function getPhone(): string
    {
      return $this->phone;
    }

    public function getDatetime(): \Datetime
    {
      return $this->datetime;
    }

    public function getStatus(): string
    {
      return $this->status;
    }

    public function getUserId(): int
    {
      return $this->user_id;
    }


}
