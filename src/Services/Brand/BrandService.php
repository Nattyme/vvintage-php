<?php

declare(strict_types=1);

namespace Vvintage\Services\Brand;

/** Модель */
use Vvintage\Models\Brand\Brand;
use Vvintage\Services\Base\BaseService;
use Vvintage\Repositories\Brand\BrandRepository;

require_once ROOT . "./libs/functions.php";

class BrandService extends BaseService
{
    protected BrandRepository $repository;

    public function __construct()
    {
       parent::__construct();
       $this->repository = new BrandRepository($this->currentLang);
      // $this->repository = new BrandRepository($this->currentLang);
    }


    // public function getBrandsArray(): array
    // {
    //   return $this->repository->getBrandsArray();
    // }

    public function getAllBrands($pagination): array
    {
      return  $this->repository->getAllBrands($pagination);
    }

    public function getAllBrandsCount(): int
    {
      return $this->repository->getAllBrandsCount();
    }

    
    public function getBrandById( int $id): ?Brand 
    {
      return $this->repository->getBrandById( $id);
    }

}
