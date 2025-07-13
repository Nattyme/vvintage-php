<?php
declare(strict_types=1);

namespace Vvintage\Services\Page;

use Vvintage\Repositories\Page\PageRepository;

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

    $pageModel = PageRepository::getBySlug($slug);
    if(!$pageModel) {
      return null;
    }

    // Получаем поля страницы и задаем модели
    $pageFields = PageFieldRepository::getByPageId( $pageModel->getId());
    $pageModel->setFields($fiуlds);

    return $pageModel;
  }

}