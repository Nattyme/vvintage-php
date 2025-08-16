<?php 
declare(strict_types=1);

namespace Vvintage\Services\Admin\Brand;

use Vvintage\Services\Brand\BrandService;
use Vvintage\DTO\Brand\BrandDTO;


final class AdminBrandService extends BrandService
{
    public function __construct()
    {
      parent::__construct();
    }

    public function updateBrand (int $id, array $data) 
    { 
      return $this->repository->updateBrand($id, $data); 
    } 
    
    public function createBrand (BrandDTO $dto) 
    { 
      return $this->repository->createBrand($dto); 
    }
}
