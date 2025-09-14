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
       $this->translationRepo = new BrandTranslationRepository($this->currentLang);
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




}
