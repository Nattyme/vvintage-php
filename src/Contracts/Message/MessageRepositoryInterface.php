<?php

declare(strict_types=1);

namespace Vvintage\Contracts\Message;

use Vvintage\Models\Message\Message;

interface MessageRepositoryInterface
{
  // Находит сообщение по id и возвращает объект
  public function getMessageById(int $id): ?Message;
  /** Находит все сообщения и возвращаем в виде массива объектов */
  public function getAllMessages(): array;
  public function getAllMessagesCount(?string $sql = null, array $params = []): int;
}
