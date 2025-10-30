<?php 
declare(strict_types=1);

namespace Vvintage\Services\Admin\Brand;

use Vvintage\Services\Brand\BrandService;
use Vvintage\DTO\Brand\BrandInputDTO;
use Vvintage\DTO\Admin\Brand\EditDTO;
use Vvintage\DTO\Brand\BrandTranslationInputDTO;
use Vvintage\DTO\Admin\Brand\BrandForAdminListDTO;
use Vvintage\DTO\Admin\Brand\BrandsForAdminListDTOFactory;
use Vvintage\DTO\Admin\Brand\BrandTranslationInputDTOFactory;
use Vvintage\DTO\Brand\BrandInputDTOFactory;
use Vvintage\DTO\Admin\Brand\EditDTOFactory;


final class AdminBrandService extends BrandService
{
    public function __construct()
    {
      parent::__construct();
    }

    public function createBrandDraft(array $data): ?int
    {
      if (!$data ) return null;
       $this->repository->begin(); 

      try {
        $dto = $this->createBrandInputDTO($data);

        if(!$dto) throw new \RuntimeException("Не удалось создать бренд");

        $brandId = $this->repository->saveBrand($dto->toArray());
        if(!$brandId) throw new \RuntimeException("Не удалось создать бренд");
    
        
        if (!empty($data['translations'])) {
          $translations = $data['translations'];
          
          $translateDto = $this->createTranslateInputDto($translations, $brandId);
          if (empty($translateDto)) throw new \RuntimeException("Не удалось сохранить бренд");

          // Приведем к массиву и передадим в БД
          $array = array_map(function($item) { return $item->toArray(); }, $translateDto);
          $result = $this->translationRepo->saveBrandTranslation($array);
          
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

    public function updateBrandDraft (int $id, array $data): ?int
    { 
      $this->repository->begin(); // начало транзакции


      try {
        // Обновляем бренд
        $dto = $this->createBrandInputDTO($data, $id);
          
        if(!$dto) throw new \RuntimeException("Не удалось обновить бренд");

        // Сохраняем бренд в БД
        $this->repository->saveBrand($dto->toArray());

        // Обновляем переводы бренда
        $this->updateBrandTranslationsDraft($id, $data);

        // Подтверждаем транзакцию
        $this->repository->commit();

        return $id;
      } catch (\Throwable $e) {
        $this->translationRepo->rollback();
        throw $e;
      }
    } 

    private function updateBrandTranslationsDraft(int $id, array $data): void 
    {
      $dto = $this->createTranslateInputDto($data['translations'], $id);

      // Приведем к массиву и передадим в БД
      $array = array_map(function($item) { return $item->toArray(); }, $dto);
      $this->translationRepo->saveBrandTranslation($array);
    }
    
    public function deleteBrand(int $id): void
    {
      $this->repository->deleteBrand($id);
    }
    



    /*** DTO */
    public function createBrandInputDTO(array $data, ?int $id=null): ?BrandInputDTO
    {
      $factory = new BrandInputDTOFactory();
      return $factory->createFromArray($data, $id);
    }

    public function createTranslateInputDto(array $data, $brandId): array 
    {
      $factory = new BrandTranslationInputDTOFactory();

      $translations = [];

      foreach($data as $locale => $translate) {
          $translations[] = $factory->createFromArray($translate, $locale, $brandId);
      }
       
      return $translations;
    }

    public function createBrandEditDTO(int $id): EditDTO
    {
        $brand = $this->getBrandById($id);
        $translations = $this->getTranslations($id);
        $brand->setTranslations($translations);

        $dtoFactory = new EditDtoFactory();
  
        return $dtoFactory->createFromBrand($brand);
    }


    public function getBrandsAdminListDTO(): array
    {
      $brands = $this->getAllBrands();
      $dtoFactory = new BrandsForAdminListDTOFactory();

      return array_map(fn($brand) => $dtoFactory->createFromBrand($brand), $brands);
    }


    // Скорее всего нужно удалить этот метод
    public function getTranslations(int $brandId): array 
    {
      return $this->translationRepo->loadTranslations($brandId);
    }


}
