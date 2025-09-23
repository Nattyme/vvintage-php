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


    // private function uniteProductRawData(?int $id = null): array
    // {
    //     $sql = '
    //         SELECT 
    //             b.*,
    //             bt.locale,
    //             bt.title,
    //             bt.description,
    //             bt.meta_title,
    //             bt.meta_description
    //         FROM ' . self::TABLE . ' b
    //         LEFT JOIN ' . self::TABLE_BRANDS_TRANSLATION . ' bt ON bt.brand_id = b.id AND bt.locale = ?

    //     ';

    //     $locale = 'ru';
    //     $bindings = [$locale];

    //     if ($id !== null) {
    //         $sql .= ' WHERE b.id = ? GROUP BY b.id LIMIT 1';
    //         $bindings[] = $id;

    //         // Заворачиваем в массив
    //         $row = R::getRow($sql, $bindings);
    //         return $row ? [$row] : [];
    //     } else {
    //         $sql .= ' GROUP BY b.id ORDER BY b.id DESC';
    //         return $this->getAll($sql, $bindings);
    //     }
    // }

    // public function createBrandDTOFromArray(array $row): BrandDTO
    // {
    //     $locale = $this->currentLocale ?? self::DEFAULT_LOCALE;
    //     return new BrandDTO([
    //         'id' => (int) $row['brand_id'],
    //         'title' => (string) ($row['brand_title_translation'] ?: $row['brand_title']),
    //         'image' => (string) ($row['brand_image'] ?? ''),
    //         'translations' => [
    //             $locale => [
    //                 'title' => $row['brand_title_translation'] ?? '',
    //                 'description' => $row['brand_description'] ?? '',
    //                 'seo_title' => $row['brand_meta_title'] ?? '',
    //                 'seo_description' => $row['brand_meta_description'] ?? '',
    //             ]
    //         ],
    //         'locale' => $locale,
    //     ]);
    // }

    // private function mapBeanToBrand(OODBBean $bean): Brand
    // {
    //     $translations = $this->translationRepo->loadTranslations((int) $bean->id);

    //     $dto = new BrandDTO([
    //         'id' => (int) $bean->id,
    //         'title' => (string) $bean->title,
    //         'image' => (string) $bean->image,
    //         'translations' => $translations
    //     ]);

    //     return Brand::fromDTO($dto);
    // }

    // private function mapBeanToArray(OODBBean $bean): array
    // {
    //   $translations = $this->translationRepo->loadTranslations((int) $bean->id);

    //   return [
    //       'id' => (int) $bean->id,
    //       'title' => (string) $bean->title,
    //       'image' => (string) $bean->image,
    //       'translations' => $translations
    //   ];
    // }

 

    /** Находим все бренды и возвращаем в виде массива объектов */
    public function getAllBrands(): array
    {
      $beans = $this->findAll( self::TABLE );

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
        $beans = $this->findAll(self::TABLE);

        // Сбрасываем ключи и преобразуем в массивы
        return array_values(array_map([$this, 'mapBeanToBrand'], $beans));
    }


    

     /** Создаёт новый OODBBean для бренда */
    private function createBrandBean(): OODBBean 
    {
        return $this->createBean(self::TABLE);
    }


    /** Сохраняет бренд с DTO */
    public function saveBrand(BrandDTO $dto): ?int
    {
        if (!$dto) {
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
            return null;
        }

        return $brandId;
    }
   

    /** Создаёт новый бренд через DTO */
    public function createBrand(BrandDTO $dto): ?int
    {
        return $this->saveBrand($dto);
    }

    /** Обновляет существующий бренд через DTO */
    public function updateBrand(BrandDTO $dto): ?int
    {
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

}
