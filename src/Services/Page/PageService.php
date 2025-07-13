<?php
declare(strict_types=1);

namespace Vvintage\Services\Page;

use Vvintage\Repositories\PageRepository;

final class PageService
{
  public function getPageBySlug(string $slug): ?Page
  {
    // Здесь дописать валидацию
    $slug = trim($slug);

    // Если пустая строка
    if($slug === '') {
      return null;
    }

    return PageRepository::getBySlug($slug);

  }

}