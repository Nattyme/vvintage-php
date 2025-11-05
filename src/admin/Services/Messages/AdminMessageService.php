<?php 
declare(strict_types=1);

namespace Vvintage\Admin\Services\Messages;

use Vvintage\Public\Services\Messages\MessageService;
use Vvintage\Repositories\Message\MessageRepository;
use Vvintage\Models\Message\Message;

final class AdminMessageService extends MessageService
{

    public function __construct()
    {
      parent::__construct();
    }

    public function getAllMessages(array $pagination): array
    {
      
      return $this->repository->getAllMessages($pagination);
    }


    public function getMessage(int $id)
    {
      return $this->repository->getMessageById($id);
    }

    public function deleteMessage(int $id): void 
    {
      $this->repository->deleteMessage($id);
    }

}
