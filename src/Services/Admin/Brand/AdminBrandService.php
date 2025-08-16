<?php 
declare(strict_types=1);

namespace Vvintage\Services\Admin\Brand;

use Vvintage\Services\Brand\BrandService;


final class AdminBrandService extends BrandService
{
    public function __construct()
    {
      parent::__construct();
    }

    public function updateBrand (int $id, array $data): int
    {
    
    }

    public function createBrand (array $data): int
    {
      return $this->repository->createBrand($data);
    }

}
