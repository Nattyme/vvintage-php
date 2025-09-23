<?php 
declare(strict_types=1);

namespace Vvintage\Services\Admin\Brand;

use Vvintage\Services\Brand\BrandService;
use Vvintage\DTO\Brand\BrandOutputDTO;
use Vvintage\DTO\Brand\BrandInputDTO;
use Vvintage\DTO\Brand\BrandTranslationInputDTO;


final class AdminBrandService extends BrandService
{
    public function __construct()
    {
      parent::__construct();
    }

    public function createBrandDraft(array $data): ?int
    {
      if (!$data) return null;

      // начало транзакции
      $this->repository->begin(); 

        try {
          $brandDto = $this->createBrandInputDTO($data);
   dd($data);
          $brandId = $this->repository->createBrand($brandDto);
    
          if(!$brandId) {
            throw new RuntimeException("Не удалось создать бренд");
            return null;
          }

          if (empty($data['translations'])) {
            throw new RuntimeException("Не удалось сохранить бренд");
            return null;
          }




      
          if (!empty($data['translations'])) {
   
            $translateDto = $this->createTranslateInputDto($data['translations'], $brandId);
       
      
            foreach($translateDto as $dto) {
              $this->translationRepo->saveTranslations($dto);
            }
          }

        
          // Подтверждаем транзакцию
          $this->repository->commit();


          return $brandId;

        }

        catch (\Throwable $error) 
        {
          $this->repository->rollback();
          throw $error;
        }
      
    }

    public function createBrandInputDTO(array $data): ?BrandInputDTO
    {

        return new BrandInputDTO([
            // 'title' => $translations[$mainLang]['title'] ?? '',
            // 'description' => $translations[$mainLang]['description'] ?? '',
            'image' => $data['image'] ?? '',
            // 'translations' => $translations,
        ]);
  
    }

    public function createTranslateInputDto(array $data, $brandId): array 
    {
      $brandTranslationsDto = [];

      foreach($data as $locale => $translate) {
          $brandTranslationsDto[] = new BrandTranslationInputDTO([
              'brand_id' => (int) $brandId,
              'locale' => (string) $locale, 
              'title' => (string) ($translate['title'] ?? ''),
              'description' => (string) ($translate['description'] ?? ''),
              'meta_title' => (string) ($translate['meta_title'] ?? $translate['title'] ?? ''),
              'meta_description' => (string) ($translate['meta_description'] ?? $translate['description'] ?? '')
          ]);
      }
          
      return  $brandTranslationsDto;

    }

    public function updateBrand (int $id, array $data) 
    { 
      return $this->repository->updateBrand($id, $data); 
    } 
    
    // public function createBrand (array $data) 
    // { 
    //   if (!$data) return null;

    //   $dto = $this->createBrandInputDTO($data);
    //   $brand = Brand::fromDTO($dto);
      
    //   return $this->repository->createBrand($dto); 
    // }

        
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

    public function createBrandDTOFromArray(array $row): BrandOutputDTO
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
