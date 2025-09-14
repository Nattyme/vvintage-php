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

    private function createBrandDTOFromArray(array $row): BrandDTO
    {
      return new BrandOutputDTO([
          'id' => (int) $row['brand_id'],
          'title' => (string) ($row['brand_title_translation'] ?: $row['brand_title']),
          'image' => (string) ($row['brand_image'] ?? ''),
          'translations' => [
              $this->locale => [
                  'title' => $row['brand_title_translation'] ?? '',
                  'description' => $row['brand_description'] ?? '',
                  'seo_title' => $row['brand_meta_title'] ?? '',
                  'seo_description' => $row['brand_meta_description'] ?? '',
              ]
          ],
          'locale' => $this->locale,
      ]);
    }

    
}
