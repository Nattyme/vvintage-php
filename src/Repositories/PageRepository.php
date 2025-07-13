<?php
declare(strict_types=1);

namespace Vvintage\Repositories;

use Vvintage\Models\Page\Page;

final class PageRepository
{
  public static function getBySlug(string $slug)
  {
    // Подключение к БД и выброрка страницы по slug
    $bean = R::findOne('pages', 'slug = ?', [$slug]);

    if (!$bean) {
        return null;
    }
    
    return new Page($bean);
  }
}