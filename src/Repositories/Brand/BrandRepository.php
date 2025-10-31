<?php

declare(strict_types=1);

namespace Vvintage\Repositories\Brand;


use RedBeanPHP\R;
use RedBeanPHP\OODBBean;


/** Контракты */
use Vvintage\Contracts\Brand\BrandRepositoryInterface;

/** Абстрактный репозиторий */
use Vvintage\Repositories\AbstractRepository;
use Vvintage\Models\Brand\Brand;
use Vvintage\DTO\Brand\BrandDTO;
use Vvintage\DTO\Brand\BrandInputDTO;



final class BrandRepository extends AbstractRepository implements BrandRepositoryInterface
{
    private const TABLE = 'brands';

    /** Создаёт новый OODBBean для бренда */
    private function createBrandBean(): OODBBean 
    {
        return $this->createBean(self::TABLE);
    }

    /** CRUD */
    public function saveBrand(array $data): ?int
    {
        // Создаем или обновляем бренд
        $bean = $data['id'] 
            ? $this->findById(self::TABLE, $data['id'])
            : $this->createBrandBean();

        $bean->title = $data['title'];
        $bean->description = $data['description'];
        $bean->image = $data['image'];

        $this->saveBean($bean);

        $id = (int) $bean->id;

        if (!$id) throw new RuntimeException("Не удалось сохранить бренд");

        return $id;
    }
   
    public function updateBrand(BrandInputDTO $dto): ?int
    {

        if (!$dto->id) {
            return null; // нельзя обновить без ID
        }

        return $this->saveBrand($dto);
    }

    public function deleteBrand(int $id): void
    {
      $bean = $this->loadBean(self::TABLE, $id);
      $this->deleteBean($bean);
    }

    // Находит бренд по id и возвращает объект
    public function getBrandById(int $id): ?Brand
    {
        $bean = $this->findById(self::TABLE, $id);

        if (!$bean || !$bean->id) {
            return null;
        }
    
        $brandArray = $this->mapBeanToArray($bean);

        return Brand::fromArray($brandArray);
    }

    /** Находим все бренды и возвращаем в виде массива объектов */
    public function getAllBrands(): array
    {
      $beans = $this->findAll( table: self::TABLE, orderBy: 'title ASC');

      if (empty($beans)) {
            return [];
      }

      $brandArray = array_map(fn($bean) => $this->mapBeanToArray($bean), $beans);


      return array_map(fn($brand) => Brand::fromArray($brand), $brandArray);
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

        $brandArray = array_map(fn($bean) => $this->mapBeanToArray($bean), $beans);

        return array_map(fn($brand) => Brand::fromArray($brand), $brandArray);
    }
    

    
    public function getAllBrandsCount(?string $sql = null, array $params = []): int
    {
      return $this->countAll(self::TABLE, $sql, $params);
    }

    // Для api
    public function getBrandsArray(): array
    {
        // Достаём все категории, у которых parent_id = NULL
        $beans = $this->findAll(table: self::TABLE, orderBy: 'title ASC');

        // Сбрасываем ключи и преобразуем в массивы
        return array_values(array_map([$this, 'mapBeanToArray'], $beans));
    }


    public function existsByTitle(string $cleaned): ?int
    {
      return $this->countAll(self::TABLE, 'LOWER(title) = ?', [mb_strtolower($cleaned)]);
    }

    private function mapBeanToArray(OODBBean $bean): array
    {
        return [
            'id' => (int) $bean->id,
            'title' => (string) $bean->title,
            'image' => (string) $bean->image
        ];
    }
}
