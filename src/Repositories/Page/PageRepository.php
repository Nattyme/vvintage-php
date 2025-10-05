<?php
declare(strict_types=1);

namespace Vvintage\Repositories\Page;

use RedBeanPHP\R; // Подключаем readbean
use RedBeanPHP\OODBBean; // для обозначения типа даннных


/** Контракты */
use Vvintage\Contracts\Page\PageRepositoryInterface;

/** Абстрактный репозиторий */
use Vvintage\Repositories\AbstractRepository;
use Vvintage\Repositories\Page\PageFieldRepository;

/** Модели */
use Vvintage\Models\Page\Page;


final class PageRepository extends AbstractRepository implements PageRepositoryInterface
{
  private const TABLE = 'pages';
  public function getPageBySlug(string $slug): ?Page
  {
    // Подключение к БД и выброрка страницы по slug
    $bean = R::findOne('pages', 'slug = ?', [$slug]);

    if (!$bean) {
        return null;
    }
    
    return new Page($bean);
  }

  public function getLocalePagesNavTitles(): array
  {
    $conditions = ['show_in_navigation = ?', 'visible = ?'];
    $params = ['1', '1'];
   
     // Вызов универсального метода
    $beans = $this->findAll(
        table: self::TABLE,
        conditions: $conditions,
        params: $params
    );

    // преобразуем каждый bean в массив
    return array_map(function($bean) {
        return $bean->export();
    }, $beans);
  }

  public function getAllPages()
  {
      // Вызов универсального метода
      $beans = $this->findAll(
          table: self::TABLE
      );

      // нормализация дат (преобразуем каждый bean в массив)
      return array_map(function($bean) {
          return $bean->export();
      }, $beans);
  }

}