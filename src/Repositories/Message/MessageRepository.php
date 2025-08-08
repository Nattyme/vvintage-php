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


    private function mapBeanToMessage(OODBBean $bean): Message
    {

        $dto = new MessageDTO([
            'id' => (int) $bean->id,
            'title' => (string) $bean->title,
            'image' => (string) $bean->image,
            'translations' => $translations
        ]);

        return Brand::fromDTO($dto);
    }


    // Находит бренд по id и возвращает объект
    public function getMessageById(int $id): ?Message
    {
        $bean = $this->findById(self::TABLE_BRANDS, $id);

        if (!$bean || !$bean->id) {
            return null;
        }

        return $this->mapBeanToBrand($bean);
    }

    /** Находим все бренды и возвращаем в виде массива объектов */
    public function getAllMessages(): array
    {
      $beans = $this->findAll( self::TABLE_BRANDS );

      if (empty($beans)) {
            return [];
      }

      return array_map([$this, 'mapBeanToBrand'], $beans);
    }

    
    public function getAllMessagesCount(?string $sql = null, array $params = []): int
    {
      return $this->countAll(self::TABLE_BRANDS, $sql, $params);
    }

}
