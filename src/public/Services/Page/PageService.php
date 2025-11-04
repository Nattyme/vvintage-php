<?php
declare(strict_types=1);

namespace Vvintage\Services\Page;

use Vvintage\Models\Page\Page;
use Vvintage\Models\Product\Product;

use Vvintage\Services\SEO\SeoService;
use Vvintage\Services\Base\BaseService;
use Vvintage\Services\Page\Breadcrumbs;

use Vvintage\DTO\Page\PageOutputDTO;

use Vvintage\Repositories\Page\PageRepository;
use Vvintage\Repositories\Page\PageTranslationRepository;
use Vvintage\Repositories\Page\PageFieldRepository;
use Vvintage\Repositories\Page\PageFieldTranslationRepository;

class PageService extends BaseService
{
  protected PageRepository $repository;
  protected PageFieldRepository $fieldsRepository;
  protected PageTranslationRepository $translationRepo;
  protected PageFieldTranslationRepository $fieldsTranslationRepo;
  protected SeoService $seoService;

  public function __construct()
  {
      parent::__construct();
      $this->repository = new PageRepository();
      $this->seoService = new SeoService();
      $this->translationRepo = new PageTranslationRepository();
      $this->fieldsRepository = new PageFieldRepository();
      $this->fieldsTranslationRepo = new PageFieldTranslationRepository();
  }

  public function buildPageData(string $type, mixed $model=null): array 
  {

    //SEO
    // $seo = $this->seoService->getSeoForPage('product', $productModel);

    // Название страницы и хлебные крошки
    // $breadcrumbs = $this->breadcrumbsService->generate($routeData, $productDto->title);
    // $pageTitle = $model->getTitle() ?? '';

    return [
          'seo' => $seo,
          'breadcrumbs' => $breadcrumbs,
          'pageTitle' => $pageTitle,
          'entity' => $entity,
      ];
  }

  public function getPageBySlug(string $slug): array
  {
    // Здесь дописать валидацию
    $slug = trim($slug);

    // Если пустая строка
    if($slug === '') {
      return null;
    }

    $pageModel = $this->repository->getPageBySlug($slug);

    if(!$pageModel) return [];

    $pageId = $pageModel->getId();
    $pageTranslations = $this->translationRepo->getTranslationsArray($pageId, $this->currentLang);
  
    $pageFields = $this->fieldsRepository->getFieldsByPageId($pageId);
    $translatedFields = [];

    foreach( $pageFields as $field) {
       $translation = $this->fieldsTranslationRepo->getTranslationsArray( (int) $field['id'], $this->currentLang);

       if(!empty($translation)) {
         $translatedFields[$field['name']] = $translation;
       } else {
        $translatedFields[$field['name']] = ['value' => $field['value']];
       }
    }

    if(!empty($translatedFields)) {
      $pageTranslations['fields'] = $translatedFields;
    }

    return $pageTranslations;
  }

  public function getPageModelBySlug(string $slug): ?Page
  {
    // Здесь дописать валидацию
    $slug = trim($slug);

    // Если пустая строка
    if($slug === '') {
      return null;
    }

    $pageModel = $this->repository->getPageBySlug($slug);

    if(!$pageModel) {
      return null;
    }

    $pageId = $pageModel->getId();
    $pageTranslations = $this->translationRepo->getTranslationsArray($pageId, $this->currentLang);
 
    $pageModel->setTranslations($pageTranslations);
    
    $pageFields = $this->fieldsRepository->getFieldsByPageId($pageId);
    $translatedFields = [];

    foreach( $pageFields as $field) {
       $translation = $this->fieldsTranslationRepo->getTranslationsArray( (int) $field['id'], $this->currentLang);

       if(!empty($translation)) {
         $translatedFields[$field['name']] = $translation;
       } else {
        $translatedFields[$field['name']] = ['value' => $field['value']];
       }
    }

    if(!empty($translatedFields)) {
      $pageTranslations['fields'] = $translatedFields;
      $pageModel->setFields($translatedFields);
    }
 
    return $pageModel;
  }


  public function getPageTranslations(int $pageId): array
  {
      $translations = $this->translationRepo->getTranslationsArray($pageId, $this->currentLang);

      if (!$translations) {
          // fallback
          $translations = $this->translationRepo->getTranslationsArray($pageId, $this->defaultLocale);
      }

      return $translations;
  }

  public function getLocalePagesNavTitles(?string $locale = null): array
  {
      $locale = $locale ?? $this->currentLang;
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
        'title' => $translations[$this->currentLang]['title'],
        'visible' => (int) $row['visible'],
        'show_in_navigation' => (int) $row['show_in_navigation'],
        'translations' => $translations
      ]);

      return $dto;
    
  }


}