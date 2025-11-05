<?php 
declare(strict_types=1);

namespace Vvintage\Public\Services\Messages;

use Vvintage\Repositories\Message\MessageRepository;
use Vvintage\Models\Message\Message;
use Vvintage\Public\DTO\Message\MessageDTO;

class MessageService
{
    protected MessageRepository $repository;

    public function __construct()
    {
      $this->repository = new MessageRepository ();
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
