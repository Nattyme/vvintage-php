<?php 
declare(strict_types=1);

namespace Vvintage\Services\Messages;

use Vvintage\Repositories\Message\MessageRepository;
use Vvintage\Models\Message\Message;
use Vvintage\DTO\Message\MessageDTO;

class MessageService
{

    public function __construct(
      private MessageRepository $repository
    )
    {
      $this->repository = $repository;
    }

    public function getAllMessagesCount(?string $sql = null, array $params = []): int
    {
      return $this->repository->getAllMessagesCount();
    }

    
    public function createMessage(array $data): ?int
    {
      return $this->repository->createMessage($data);
    }

}
