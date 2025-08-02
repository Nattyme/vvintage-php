<?php
declare(strict_types=1);

namespace Vvintage\Repositories\Page;

use RedBeanPHP\OODBBean; // для обозначения типа даннных
use RedBeanPHP\R; // Подключаем readbean


/** Контракты */
use Vvintage\Contracts\Page\PageFieldRepositoryInterface;

/** Абстрактный репозиторий */
use Vvintage\Repositories\AbstractRepository;

/** Модели */
use Vvintage\Models\Page\PageField;


final class PageFieldRepository extends AbstractRepository implements PageFieldRepositoryInterface
{
  public static function getFieldsByPageId (int $pageId): array
  {
    // Найдём страницу
    $bean = $this->loadBean('pages', $pageId);
  
    // Получить список всех связанных полей страницы
    $fields = $bean->ownPageFieldsList;

    // Преобразуем каждый bean из pagefield в объект модели PageField
    return array_map(fn($bean) => new PageField($bean), $fields);

  }

  public static function saveFields (int $id, array $pageFields): void
  {
    // Найдем страницу
    $bean = $this->loadBean('pages', $id);
    $bean->ownPageFieldsList = [];

    foreach ($pageFields as $name => $value) {
      $field = R::dispense('page_fields');
      $field->name = $name;
      $field->value = $value;

      // Добавляем новое поле к странице.
      $bean->ownPageFieldsList[] = $field;
    }

    $this->saveBean($bean);

  }
}