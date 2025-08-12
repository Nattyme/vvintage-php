<?php 
declare(strict_types=1);

namespace Vvintage\Services\Admin;

use Vvintage\Services\Messages\MessageService;
use Vvintage\Repositories\Message\MessageRepository;
use Vvintage\Models\Message\Message;
use Vvintage\DTO\Message\MessageDTO;

final class AdminMessageService extends MessageService
{

    public function __construct()
    {
      parent::__construct();
    }

    public function getAllMessages(array $pagination): array
    {
      
      return $this->messageRepository->getAllMessages($pagination);
    }


    public function getMessage(int $id)
    {
      return $this->messageRepository->getMessageById($id);
    }

}
