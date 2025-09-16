<?php

declare(strict_types=1);

namespace Vvintage\Services\Brand;

/** Модель */
use Vvintage\Models\Brand\Brand;
use Vvintage\Services\Base\BaseService;

use Vvintage\Repositories\Brand\BrandRepository;
use Vvintage\Repositories\Brand\BrandTranslationRepository;

use Vvintage\DTO\Brand\BrandInputDTO;
use Vvintage\DTO\Brand\BrandOutputDTO;

require_once ROOT . "./libs/functions.php";

class BrandService extends BaseService
{
    private BrandRepository $repository;
    private BrandTranslationRepository $translationRepo;

    public function __construct()
    {
       parent::__construct();
       $this->repository = new BrandRepository();
       $this->translationRepo = new BrandTranslationRepository($this->locale);
    }

    public function getAllBrands(): array
    {
      return  $this->repository->getAllBrands();
    }

    public function getAllBrandsCount(): int
    {
      return $this->repository->getAllBrandsCount();
    }

    
    public function getBrandById( int $id): ?Brand 
    {
      $brand = $this->repository->getBrandById($id);

      if (!$brand) {
          return null;
      }

      $translation = $this->getBrandTranslations($id);
      $brand->setTranslations($translation);

      return $brand;
    }

    public function getBrandsArray(): array
    {
      $brands = $this->repository->getBrandsArray();

      if (!$brands) {
        return [];
      }

      $this->setBrandsWithTranslations($brands);
      return $brands;
    }

    public function getBrandTranslations(int $brandId): array
    {
        $translations = $this->translationRepo->findTranslations($brandId, $this->locale);

        if (!$translations) {
            // fallback
            $translations = $this->translationRepo->findTranslations($brandId, $this->locale);
        }

        return $translations;
    }

    public function getBrandDTO(int $brandId): ?BrandDTO
    {
        $brand = $this->repository->getBrandById($brandId);
        if (!$brand) return null;
        
        // получаем переводы из репозитория переводов
        $translations = $this->translationRepo->findTranslations(
            $brandId,
            $this->locale
        ) ?? $this->translationRepo->findTranslations($brandId, $this->localeService->getDefaultLocale());

        return new BrandOutputDTO([
            'id' => $brand->getId(),
            'title' => $translations['title'] ?? $brand->getTitle(),
            'image' => $brand->getImage(),
            'translations' => [$this->locale => $translations ?? []],
        ]);
    }


    public function getBrandWithTranslations(int $brandId): array
    {
        // 1. Берём основной бренд
        $brand = $this->repository->getBrandById($brandId);
        if (!$brand) {
            return [];
        }

        // 2. Берём переводы из отдельного репозитория
        $translations = $this->translationRepo->findTranslations($brandId, $this->locale);

        if (!$translations) {
            // fallback на дефолтный язык
            $translations = $this->translationRepo->findTranslations($brandId, $this->localeService->getDefaultLocale());
        }

        // 3. Объединяем данные в сервисе
        return [
            'id' => $brand->getId(),
            'title' => $translations['title'] ?? $brand->getTitle(),
            'description' => $translations['description'] ?? '',
            'seo_title' => $translations['meta_title'] ?? '',
            'seo_description' => $translations['meta_description'] ?? '',
            'image' => $brand->getImage(),
        ];
    }

    public function createBrandOutputDTO(int $id): BrandOutputDTO
    {
        $brand = $this->getBrandById($id);
        return new BrandOutputDTO([
            'id' => (int) $brand->getId(),
            'title' => (string) ($brand->getTranslatedTitle() ?: $brand->getTitle()),
            'image' => (string) ($row['brand_image'] ?? ''),
            'translations' => [
                $this->locale => [
                    'title' => $brand->getTranslatedTitle() ?? '',
                    'description' => $brand->getTranslatedDescription() ?? '',
                    'seo_title' => $brand-> getSeoTitle() ?? '',
                    'seo_description' => $brand->getSeoDescription() ?? '',
                ]
            ],
            'locale' => $this->locale,
        ]);
    }
    // public function createBrandDTOFromArray(array $row): BrandOutputDTO
    // {
    //     return new BrandOutputDTO([
    //         'id' => (int) $row['brand_id'],
    //         'title' => (string) ($row['brand_title_translation'] ?: $row['brand_title']),
    //         'image' => (string) ($row['brand_image'] ?? ''),
    //         'translations' => [
    //             $this->locale => [
    //                 'title' => $row['brand_title_translation'] ?? '',
    //                 'description' => $row['brand_description'] ?? '',
    //                 'seo_title' => $row['brand_meta_title'] ?? '',
    //                 'seo_description' => $row['brand_meta_description'] ?? '',
    //             ]
    //         ],
    //         'locale' => $this->locale,
    //     ]);
    // }

    // private function mapBeanToBrand(OODBBean $bean): Brand
    // {
    //     $translations = $this->translationRepo->loadTranslations((int) $bean->id);

    //     $dto = new BrandDTO([
    //         'id' => (int) $bean->id,
    //         'title' => (string) $bean->title,
    //         'image' => (string) $bean->image,
    //         'translations' => $translations
    //     ]);

    //     return Brand::fromDTO($dto);
    // }

    // private function mapBeanToArray(OODBBean $bean): array
    // {
    //   $translations = $this->translationRepo->loadTranslations((int) $bean->id);

    //   return [
    //       'id' => (int) $bean->id,
    //       'title' => (string) $bean->title,
    //       'image' => (string) $bean->image,
    //       'translations' => $translations
    //   ];
    // }

      private function setBrandsWithTranslations(array $brands): array
      {
          foreach ($brands as $brand) {
              $translations = $this->translationRepo->getTranslationsArray($brand->getId());
              $brand->setTranslations($translations);
          }
          return $brands;
      }


}
