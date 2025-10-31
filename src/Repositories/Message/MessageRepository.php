<?php
declare(strict_types=1);

namespace Vvintage\Repositories\Message;

use RedBeanPHP\R;
use RedBeanPHP\OODBBean;

/** Контракты */
use Vvintage\Contracts\Message\MessageRepositoryInterface;

/** Абстрактный репозиторий */
use Vvintage\Repositories\AbstractRepository;

use Vvintage\Models\Message\Message;
use Vvintage\DTO\Message\MessageDTO;



final class MessageRepository extends AbstractRepository implements MessageRepositoryInterface
{
    private const TABLE = 'messages';

    private function createMessageBean(): OODBBean 
    {
        return $this->createBean(self::TABLE);
    }

    public function createMessage(array $data): ?int
    {
        $bean = $this->createMessageBean();

        $bean->name =  $data['name'];
        $bean->phone = $data['phone'];
        $bean->email = $data['email'];
        $bean->message = $data['message'];

        $this->saveBean($bean);

        $id = (int) $bean->id;

        if (!$id) throw new RuntimeException("Не удалось сохранить сообщение");

        return $id;

    }

    public function deleteMessage(int $id): void
    {
      $bean = $this->loadBean(self::TABLE, $id);
      $this->deleteBean($bean);
    }


    private function mapBeanToMessage(OODBBean $bean): Message
    {

        $dto = MessageDTO::fromDatabase([
            'id' => (int) $bean->id,
            'email' => (string) $bean->email,
            'name' => (string) $bean->name,
            'message' => (string) $bean->message,
            'phone' => (string) $bean->phone,
            'datetime' => (string) $bean->datetime,
            'status' => (string) $bean->status,
            'user_id' => (string) $bean->user_id
          
        ]);

        return Message::fromDTO($dto);
    }


    // Находит бренд по id и возвращает объект
    public function getMessageById(int $id): ?Message
    {
        $bean = $this->findById(self::TABLE, $id);

        if (!$bean || !$bean->id) {
            return null;
        }

        return $this->mapBeanToMessage($bean);
    }

    /** Находим все бренды и возвращаем в виде массива объектов */
    public function getAllMessages(): array
    {
      $beans = $this->findAll( table: self::TABLE, orderBy: 'id DESC');

      if (empty($beans)) {
            return [];
      }

      return array_map([$this, 'mapBeanToMessage'], $beans);
    }

    
    public function getAllMessagesCount(?string $sql = null, array $params = []): int
    {
      return $this->countAll(self::TABLE, $sql, $params);
    }

}
