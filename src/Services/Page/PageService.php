<?php
declare(strict_types=1);

namespace Vvintage\Services\Page;

use Vvintage\Models\Page\Page;
use Vvintage\Repositories\Page\PageRepository;
use Vvintage\Repositories\Page\PageTranslationRepository;
use Vvintage\Repositories\Page\PageFieldRepository;

final class PageService extends BaseService
{
  public function __construct()
  {
      parent::__construct();
      $this->repository = new PageRepository();
      $this->translationRepo = new PageTranslationRepository();
  }

  public function getPageBySlug(string $slug): ?Page
  {
    // Здесь дописать валидацию
    $slug = trim($slug);

    // Если пустая строка
    if($slug === '') {
      return null;
    }

    $pageModel = PageRepository::getPageBySlug($slug);
    if(!$pageModel) {
      return null;
    }

    // Получаем поля страницы и задаем модели
    $pageFieldRepo = new PageFieldRepository( (int) $pageModel->getId() );

    $pageFields = $pageFieldRepo->getFieldsByPageId();

    $pageModel->setFields($pageFields);

    return $pageModel;
  }


  public function getPageTranslations(int $pageId): array
  {
      $translations = $this->translationRepo->getTranslationsArray($pageId, $this->locale);

      if (!$translations) {
          // fallback
          $translations = $this->translationRepo->getTranslationsArray($pageId, $this->defaultLocale);
      }

      return $translations;
  }

  public function getPagesTitle(): array
  {
      $rows = $this->repository->getAllPages();

      if(empty($rows)) return [];

      return array_map([$this, 'createPageDTOFromArray'], $rows);
  }


}