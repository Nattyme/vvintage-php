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
  public static function getPageBySlug(string $slug): ?Page
  {
    // Подключение к БД и выброрка страницы по slug
    $bean = R::findOne('pages', 'slug = ?', [$slug]);

    if (!$bean) {
        return null;
    }
    
    return new Page($bean);
  }

  public function getAllPages(): array
  {
      // Вызов универсального метода
      $beans = $this->findAll(
          table: self::TABLE
      );

   
      return array_map([$this, ''], $beans);
  }
}