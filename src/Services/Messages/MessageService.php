<?php 
declare(strict_types=1);

namespace Vvintage\Services\Messages;

use Vvintage\Repositories\Message\MessageRepository;
use Vvintage\Models\Message\Message;
use Vvintage\DTO\Message\MessageDTO;

class MessageService
{
    protected MessageRepository $messageRepository;

    public function __construct()
    {
      $this->messageRepository = new MessageRepository ();
    }

    public function getAllMessagesCount(): int
    {
      return $this->messageRepository->getAllMessagesCount();
    }

}
