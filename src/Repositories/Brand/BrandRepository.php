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



final class BrandRepository extends AbstractRepository implements BrandRepositoryInterface
{
    private function uniteProductRawData(?int $id = null): array
    {
        $sql = '
            SELECT 
                b.*,
                bt.locale,
                bt.title,
                bt.description,
                bt.meta_title,
                bt.meta_description
            FROM brands b
            LEFT JOIN brands_translation bt ON bt.brand_id = b.id AND bt.locale = ?

        ';

        $locale = 'ru';
        $bindings = [$locale];

        if ($id !== null) {
            $sql .= ' WHERE b.id = ? GROUP BY b.id LIMIT 1';
            $bindings[] = $id;

            // Заворачиваем в массив
            $row = R::getRow($sql, $bindings);
            return $row ? [$row] : [];
        } else {
            $sql .= ' GROUP BY b.id ORDER BY b.id DESC';
            return R::getAll($sql, $bindings);
        }
    }

    private function mapBeanToBrand(OODBBean $bean): Brand
    {
        $translations = $this->loadTranslations((int) $bean->id);

        $dto = new BrandDTO([
            'id' => (int) $bean->id,
            'title' => (string) $bean->title,
            'image' => (string) $bean->image,
            'translations' => $translations
        ]);

        return Brand::fromDTO($dto);
    }

    /**
     * Загружает переводы из brands_translation
     */
    private function loadTranslations(int $id): array
    {
        $rows = R::getAll(
            'SELECT locale, title, description, meta_title, meta_description FROM brands_translation WHERE brand_id = ?',
            [$id]
        );

        $translations = [];
        foreach ($rows as $row) {
            $translations[$row['locale']] = [
                'title' => $row['title'],
                'description' => $row['description'],
                'meta_title' => $row['meta_title'],
                'meta_description' => $row['meta_description'],
            ];
        }

        return $translations;
    }


    // Находит бренд по id и возвращает объект
    public function getBrandById(int $id): ?Brand
    {
        $bean = $this->findById('brands', $id);

        if (!$bean || !$bean->id) {
            return null;
        }

        return $this->mapBeanToBrand($bean);
    }

    /** Находим все бренды и возвращаем в виде массива объектов */
    public function getBrands (): array
    {
      $beans = $this->findAll('brands');

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

        $beans = $this->findByIds('brands', $ids);

        if (empty($beans)) {
            return [];
        }

        return array_map([$this, 'mapBeanToBrand'], $beans);
    }


    public function saveBrand(Brand $brand): ?int
    {
        if (!$brand) {
          return null;
        }

        $bean = $brand->getId() ? $this->loadBean('brands', $brand->getId()) : $this->createBean('brands');

        if (!$bean) {
          return null;
        }
 
        $bean->title = $brand->getTitle(); // по умолчанию ru
        $bean->image = $brand->getImage();

        $id = (int) $this->saveBean($bean);

        if ( !$id) {
          return null;
        }

        // Сохраняем переводы в отдельную таблицу
        R::exec('DELETE FROM brands_translation WHERE brand_id = ?', [$id]);
        foreach ($brand->getAllTranslations() as $locale => $translation) {
            $transBean = $this->createBean('brands_translation');
            $transBean->brand_id = $id;
            $transBean->locale = $locale;
            $transBean->title = $translation['title'] ?? '';
            $transBean->description = $translation['description'] ?? '';
            $transBean->meta_title = $translation['meta_title'] ?? '';
            $transBean->meta_description = $translation['meta_description'] ?? '';

            $this->saveBean($transBean);
        }

        return $id;
    }


}
