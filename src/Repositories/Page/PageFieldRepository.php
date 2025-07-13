<?php
declare(strict_types=1);

namespace Vvintage\Repositories\Page;

use RedBeanPHP\OODBBean; // для обозначения типа даннных
use RedBeanPHP\R; // Подключаем readbean
use Vvintage\Models\Page\PageField;


final class PageFieldRepository
{
  public static function getFieldsByPageId (int $pageId): array
  {
    // Найдём страницу
    $bean = R::load('pages', $pageId);
  
    // Получить список всех связанных полей страницы
    $fields = $bean->ownPageFieldsList;

    // Преобразуем каждый bean из pagefield в объект модели PageField
    return array_map(fn($bean) => new PageField($bean), $fields);

  }

  public static function saveFields (int $pageId, array $pageFields): void
  {
    // Найдем страницу
    $page = R::load('pages', $pageId);
    $page->ownPageFieldsList = [];

    foreach ($pageFields as $name => $value) {
      $field = R::dispense('page_fields');
      $field->name = $name;
      $field->value = $value;

      // Добавляем новое поле к странице.
      $page->ownPageFieldsList[] = $field;
    }

    R::store($page);

  }
}