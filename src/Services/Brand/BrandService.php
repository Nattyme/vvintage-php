<?php

declare(strict_types=1);

namespace Vvintage\Services\Brand;

/** Модель */
use Vvintage\Models\Brand\Brand;
use Vvintage\Services\Base\BaseService;

use Vvintage\Repositories\Brand\BrandRepository;
use Vvintage\Repositories\Brand\BrandTranslationRepository;

use Vvintage\DTO\Brand\BrandInputDTO;

require_once ROOT . "./libs/functions.php";

class BrandService extends BaseService
{
    private BrandRepository $brandRepo;
    private BrandTranslationRepository $translationRepo;

    public function __construct()
    {
       parent::__construct();
       $this->brandRepo = new BrandRepository();
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
      return $this->repository->getBrandById( $id);
    }

    public function getBrandsArray(): array
    {
      return $this->repository->getBrandsArray();
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
        $brand = $this->brandRepo->getBrandById($brandId);
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
        $brand = $this->brandRepo->getBrandById($brandId);
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




}
