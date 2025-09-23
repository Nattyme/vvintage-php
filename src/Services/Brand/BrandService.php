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
    protected BrandRepository $repository;
    protected BrandTranslationRepository $translationRepo;

    public function __construct()
    {
       parent::__construct();
       $this->repository = new BrandRepository();
       $this->translationRepo = new BrandTranslationRepository();
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

    public function getAllBrands(): array
    {
      return  $this->repository->getAllBrands();
    
    }
    public function getAllBrandsDto(): array
    {
      $rows =  $this->repository->getAllBrands();
      return array_map([$this, 'createBrandOutputDTO'], array_column($rows, 'id'));
    }


    public function getAllBrandsCount(): int
    {
      return $this->repository->getAllBrandsCount();
    }

    
 


    // Для api
    public function getBrandsArray(): array
    {
      $brands = $this->repository->getBrandsArray();

      if (!$brands) {
        return [];
      }

      $brandsWithTranslation = array_map(function ($brand) {
          return $this->addBrandTranslate($brand);
      }, $brands);

      return array_values($brandsWithTranslation);
    }

    private function addBrandTranslate(array $brand): array
    {
      $translations = $this->translationRepo->getTranslationsArray($brand['id'], $this->locale ?? []);

      return array_merge($brand, [
        'title' => $translations['title'] ?? null,
        'description' => $translations['description'] ?? null,
        'seo_title' => $translations['meta_title'] ?? null,
        'seo_description' => $translations['meta_description'] ?? null,
      ]);
    }
    // Для api





    public function getBrandTranslations(int $brandId): array
    {
        $translations = $this->translationRepo->getTranslationsArray($brandId, $this->locale);

        if (!$translations) {
            // fallback
            $translations = $this->translationRepo->getTranslationsArray($brandId, $this->locale);
        }

        return $translations;
    }

    public function getBrandDTO(int $brandId): ?BrandDTO
    {
        $brand = $this->repository->getBrandById($brandId);
        if (!$brand) return null;
        
        // получаем переводы из репозитория переводов
        $translations = $this->translationRepo->getTranslationsArray(
            $brandId,
            $this->locale
        ) ?? $this->translationRepo->getTranslationsArray($brandId, $this->localeService->getDefaultLocale());

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
        $translations = $this->translationRepo->getTranslationsArray($brandId, $this->locale);

        if (!$translations) {
            // fallback на дефолтный язык
            $translations = $this->translationRepo->getTranslationsArray($brandId, $this->localeService->getDefaultLocale());
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

    public function createBrandOutputDTO(int $id): ?BrandOutputDTO
    {
        $brand = $this->getBrandById($id);

        if(!$brand) return null;

        $translations = $this->translationRepo->loadTranslations($id);
      
        return new BrandOutputDTO([
            'id' => (int) $id,
            'title' => (string) ($brand->getTranslatedTitle($this->locale) ?? ''),
            'image' => (string) ($row['brand_image'] ?? ''),
            'translations' => [
                $this->locale => [
                    'title' => $brand->getTranslatedTitle($this->locale) ?? '',
                    'description' => $brand->getTranslatedDescription($this->locale) ?? '',
                    'meta_title' => $brand-> getSeoTitle($this->locale) ?? '',
                    'meta_description' => $brand->getSeoDescription($this->locale) ?? '',
                ]
            ],
            // 'locale' => $this->locale,
        ]);
    }

    // private function createBrandDTOFromArray(array $row): BrandOutputDTO
    // {
    //     $brandId = (int) $row['id'];
    //     $translations = $this->translationRepo->loadTranslations($brandId);
 
    //     return new BrandOutputDTO([
    //         'id' => (int) $brandId,
    //         'title' => (string)  ($translations[$this->locale]['title'] ?? ''),
    //         'description' => (string) ($translations[$this->locale]['description'] ?? ''),
    //         'image' => (string) ($row['brand_image'] ?? ''),
    //         'translations' => $translations
    //         // 'locale' => (string) $this->locale,
    //     ]);
     
    // }

 


}
