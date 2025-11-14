<?php
declare(strict_types=1);

namespace Vvintage\Repositories\Page;

use RedBeanPHP\OODBBean; // для обозначения типа даннных
use RedBeanPHP\R; // Подключаем readbean


/** Контракты */
// use Vvintage\Contracts\Page\PageFieldRepositoryInterface;

/** Абстрактный репозиторий */
use Vvintage\Repositories\AbstractRepository;

/** Модели */
use Vvintage\Models\Page\PageField;


// final class PageFieldRepository extends AbstractRepository implements PageFieldRepositoryInterface
final class PageFieldRepository extends AbstractRepository
{
  //  private int $pageId;
  private const TABLE = 'pagefields';

  //  public function __construct(int $pageId) {
  //   $this->pageId = $pageId;
  //  }

  public function getFieldsByPageId ($pageId): array
  {
    // Получить список всех связанных полей страницы
    $beans = $this->findAll(table: self::TABLE, conditions: ['page_id = ?'], params: [$pageId]);

    // Преобразуем каждый bean из pagefield в объект модели PageField
    // преобразуем каждый bean в массив
    return array_map(function($bean) {
        return $bean->export();
    }, $beans);
    // return array_map(fn($bean) => new PageField($bean), $fields);

  }

  public function saveFields (int $id, array $pageFields): void
  {
    // Найдем страницу
    $bean = $this->loadBean('pages', $id);
    $bean->ownPagefieldsList = [];

    foreach ($pageFields as $name => $value) {
      $field = $this->createBean('pagefields');
      $field->name = $name;
      $field->value = $value;

      // Добавляем новое поле к странице.
      $bean->ownPagefieldsList[] = $field;
    }

    $this->saveBean($bean);

  }
}