<?php

declare(strict_types=1);

namespace Vvintage\Services\Brand;

/** Модель */
use Vvintage\Models\Brand\Brand;
use Vvintage\Services\Base\BaseService;

use Vvintage\Repositories\Brand\BrandRepository;

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
       $this->translationRepo = new BrandTranslationRepository();
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


    
    public function saveBrand(BrandInputDTO $dto, array $translations): int
    {
        $this->brandRepo->begin();

        try {
            $brandId = $this->brandRepo->save($dto);
            $this->translationRepo->saveTranslations($brandId, $translations);

            $this->brandRepo->commit();
            return $brandId;
        } catch (\Throwable $e) {
            $this->brandRepo->rollback();
            throw $e;
        }
    }

}
