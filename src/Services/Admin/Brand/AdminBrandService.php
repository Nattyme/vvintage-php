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

    public function createBrandDraft(array $data, array $images): ?int
    {
      if (!$data) return null;

    
      // $brand = Brand::fromDTO($dto);
      
      // return $this->repository->createBrand($dto);
       
            // Сохраняем переводы
        // foreach ($dto->translations as $locale => $fields) {
        //     $this->translationRepo->saveTranslations($brandId, $locale, $fields);
        // }

      $this->repository->begin(); // начало транзакции

        try {
          $brandDto = $this->createBrandInputDTO($data);
          $brandId = $this->repository->createBrand($dto);

          if( !$brandId) {
            throw new RuntimeException("Не удалось создать бренд");
            return null;
          }

      
          if (!empty($data['translations'])) {
            $translateDto = $this->createTranslateInputDto($data['translations'], $brandId);
            $this->translationRepo->saveProductTranslation($translateDto);
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
        $translations = [];
        foreach ($data['title'] as $lang => $title) {
            $translations[$lang] = [
                'title' => $data['title'][$lang] ?? '',
                'description' => $data['description'][$lang] ?? '',
                'meta_title' => $data['meta_title'][$lang] ?? '',
                'meta_description' => $data['meta_description'][$lang] ?? '',
            ];
        }

        $mainLang = 'ru';

        return new BrandInputDTO([
            'title' => $translations[$mainLang['title']] ?? '',
            'description' => $translations[$mainLang['description']] ?? '',
            'image' => $data['image'] ?? '',
            'translations' => $translations,
        ]);
        // $brand = $this->repository->getBrandById($brandId);
        // if (!$brand) return null;
        
        // получаем переводы из репозитория переводов
        // $translations = $this->translationRepo->getTranslationsArray(
        //     $brandId,
        //     $this->locale
        // ) ?? $this->translationRepo->getTranslationsArray($brandId, $this->localeService->getDefaultLocale());

        // return new BrandOutputDTO([
        //     'id' => $brand->getId(),
        //     'title' => $translations['title'] ?? $brand->getTitle(),
        //     'image' => $brand->getImage(),
        //     'translations' => [$this->locale => $translations ?? []],
        // ]);
    }

    public function createTranslateInputDto(array $data, $brandId): array 
    {
      $brandTranslationsDto = [];

      foreach($data as $locale => $translate) {
          $brandTranslationsDto[] = new BrandTranslationInputDTO([
              'brand_id' => (int) ($brandId ?? 0),
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
