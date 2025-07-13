<?php
declare(strict_types=1);

namespace Vvintage\Repositories\Page;

use Vvintage\Models\Page\Page;
use Vvintage\Repositories\Page\PageFieldRepository;

final class PageRepository
{
  public static function getBySlug(string $slug): ?Page
  {
    // Подключение к БД и выброрка страницы по slug
    $bean = R::findOne('pages', 'slug = ?', [$slug]);

    if (!$bean) {
        return null;
    }
    
    return new Page($bean);
  }
}