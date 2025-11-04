<?php

declare(strict_types=1);

namespace Vvintage\public\Services\Brand;

/** Модель */
use Vvintage\Models\Brand\Brand;
use Vvintage\public\Services\Base\BaseService;

use Vvintage\Repositories\Brand\BrandRepository;
use Vvintage\Repositories\Brand\BrandTranslationRepository;

use Vvintage\public\DTO\Brand\BrandInputDTO;
use Vvintage\public\DTO\Brand\BrandForProductDTO;
use Vvintage\public\DTO\Brand\BrandForProductDTOFactory;

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

      $translation = $this->translationRepo->loadTranslations($id);
      $brand->setTranslations($translation);

      return $brand;
    }

    public function getAllBrands(): array
    {
      return  $this->repository->getAllBrands();
    }

    public function getAllBrandsDto(): array
    {
      $brandsArray =  $this->repository->getBrandsArray();

      return array_map([$this, 'createBrandProductDTO'], array_column($brandsArray, 'id'));
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
      $translations = $this->translationRepo->getLocaleTranslation($brand['id'], $this->currentLang ?? []);

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
        $translations = $this->translationRepo->getLocaleTranslation($brandId, $this->currentLang);

        if (!$translations) {
            // fallback
            $translations = $this->translationRepo->getLocaleTranslation($brandId, $this->currentLang);
        }

        return $translations;
    }


    public function createBrandProductDTO(int $id): ?BrandForProductDTO
    {
        $brand = $this->getBrandById($id);
  
        if(!$brand) return null;

        $dtoFactory = new BrandForProductDTOFactory();
        $dto = $dtoFactory->createFromBrand($brand, $this->currentLang);

        return $dto; 
    }

}
