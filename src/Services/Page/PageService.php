<?php
declare(strict_types=1);

namespace Vvintage\Services\Page;

use Vvintage\Models\Page\Page;
use Vvintage\Services\Base\BaseService;
use Vvintage\DTO\Page\PageOutputDTO;
use Vvintage\Repositories\Page\PageRepository;
use Vvintage\Repositories\Page\PageTranslationRepository;
use Vvintage\Repositories\Page\PageFieldRepository;

class PageService extends BaseService
{
  protected PageRepository $repository;
  protected PageFieldRepository $fieldsRepository;
  protected PageTranslationRepository $translationRepo;

  public function __construct()
  {
      parent::__construct();
      $this->repository = new PageRepository();
      $this->translationRepo = new PageTranslationRepository();
      $this->fieldsRepository = new PageTranslationRepository();
      $this->translationFieldsRepo = new PageTranslationRepository();
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

  public function getLocalePagesNavTitles(?string $locale = null): array
  {
      $locale = $locale ?? $this->locale;
      $rows = $this->repository->getLocalePagesNavTitles();

      if (empty($rows)) return [];

      return array_map(function ($row) use ($locale) {
          $translations = $this->translationRepo->loadTranslations((int)$row['id']);
          return [
              'id' => $row['id'],
              'slug' => $row['slug'],
              'title' => $translations[$locale]['title'] ?? $row['title']
          ];
      }, $rows);
  }


  public function getPages($filter = []): array
  {
    $rows = $this->repository->getAllPages($filter);

    if(empty($rows)) return [];

    return array_map([$this, 'createPageDTOFromArray'], $rows);
  }

  private function createPageDTOFromArray(array $row): PageOutputDTO
  {
      $pageId = (int) $row['id'];
      $translations = $this->translationRepo->loadTranslations($pageId);

      $dto = new PageOutputDTO([
        'id' => $pageId,
        'slug' => $row['slug'],
        'title' => $translations[$this->locale]['title'],
        'visible' => (int) $row['visible'],
        'show_in_navigation' => (int) $row['show_in_navigation'],
        'translations' => $translations
      ]);

      return $dto;
    
  }


}