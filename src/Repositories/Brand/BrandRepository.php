<?php

declare(strict_types=1);

namespace Vvintage\Repositories\Brand;


use RedBeanPHP\R;
use RedBeanPHP\OODBBean;


/** Контракты */
use Vvintage\Contracts\Brand\BrandRepositoryInterface;

/** Абстрактный репозиторий */
use Vvintage\Repositories\AbstractRepository;
// use Vvintage\Repositories\Brand\BrandTranslationRepository;

use Vvintage\Models\Brand\Brand;
use Vvintage\DTO\Brand\BrandDTO;
use Vvintage\DTO\Brand\BrandInputDTO;



final class BrandRepository extends AbstractRepository implements BrandRepositoryInterface
{
    private const TABLE = 'brands';

    // Находит бренд по id и возвращает объект
    public function getBrandById(int $id): ?Brand
    {
        $bean = $this->findById(self::TABLE, $id);

        if (!$bean || !$bean->id) {
            return null;
        }
        $brandArray = $this->mapBeanToBrand($bean);

        return Brand::fromArray($brandArray);
    }

    /** Находим все бренды и возвращаем в виде массива объектов */
    public function getAllBrands(): array
    {
      $beans = $this->findAll( table: self::TABLE );

      if (empty($beans)) {
            return [];
      }

      return array_map([$this, 'mapBeanToBrand'], $beans);
    }

    /** Возвращает массив объеков Brands по определенным id */
    public function getBrandsByIds(array $ids): array
    {
        if (empty($ids)) {
            return [];
        }

        $beans = $this->findByIds(self::TABLE, $ids);

        if (empty($beans)) {
            return [];
        }

        return array_map([$this, 'mapBeanToBrand'], $beans);
    }
    
    public function getAllBrandsCount(?string $sql = null, array $params = []): int
    {
      return $this->countAll(self::TABLE, $sql, $params);
    }

    // Для api
    public function getBrandsArray(): array
    {
        // Достаём все категории, у которых parent_id = NULL
        $beans = $this->findAll(table: self::TABLE);

        // Сбрасываем ключи и преобразуем в массивы
        return array_values(array_map([$this, 'mapBeanToBrand'], $beans));
    }


    

     /** Создаёт новый OODBBean для бренда */
    private function createBrandBean(): OODBBean 
    {
        return $this->createBean(self::TABLE);
    }


    /** Сохраняет бренд с DTO */
    public function saveBrand(BrandInputDTO $dto): ?int
    {

        if (!$dto) {
          throw new RuntimeException("Не удалось сохранить бренд");
          return null;
        }

        // Создаем или загружаем бренд
        $brandBean = $dto->id 
            ? $this->findById(self::TABLE, $dto->id)
            : $this->createBrandBean();

        $brandBean->title = $dto->title;
        $brandBean->image = $dto->image;

        $this->saveBean($brandBean);

        $brandId = (int)$brandBean->id;

        if (!$brandId) {
          throw new RuntimeException("Не удалось сохранить бренд");
          return null;
        }

        return $brandId;
    }
   

    /** Создаёт новый бренд через DTO */
    public function createBrand(BrandInputDTO $dto): ?int
    {
        return $this->saveBrand($dto);
    }

    /** Обновляет существующий бренд через DTO */
    public function updateBrand(BrandInputDTO $dto): ?int
    {
      dd($dto);
        if (!$dto->id) {
            return null; // нельзя обновить без ID
        }

        return $this->saveBrand($dto);
    }


    public function existsByTitle(string $cleaned): ?int
    {
      return $this->countAll(self::TABLE, 'LOWER(title) = ?', [mb_strtolower($cleaned)]);
    }

    private function mapBeanToBrand(OODBBean $bean): array
    {
        return [
            'id' => (int) $bean->id,
            'image' => (string) $bean->image
        ];
    }

    public function deleteBrand(int $id): void
    {
      $bean = $this->loadBean(self::TABLE, $id);
      $this->deleteBean($bean);
    }


}
