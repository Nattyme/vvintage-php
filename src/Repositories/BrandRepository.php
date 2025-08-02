<?php

declare(strict_types=1);

namespace Vvintage\Repositories;

use Vvintage\Models\Brand\Brand;

use RedBeanPHP\R;
use RedBeanPHP\OODBBean;

final class BrandRepository
{
    private function findById(int $id): ?OODBBean
    {
        $bean = R::findOne('brands', 'id = ?', [$id]);
        return $bean ?: null;
    }

    private function uniteProductRawData(?int $id = null): array
    {
        $sql = '
            SELECT 
                b.*,
                bt.locale,
                bt.title,
                bt.description,
                bt.meta_title,
                bt.meta_description,
            FROM brands b
            LEFT JOIN brands_translation pt ON bt.brand_id = b.id AND bt.locale = ?
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
     * Загружает переводы из categories_translation
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
        $bean = $this->findById($id);

        if (!$bean || !$bean->id) {
            return null;
        }

        return $this->mapBeanToBrand($bean);
    }



    private function findAll(): array
    {
        return R::findAll('brands', 'ORDER BY id DESC ');
    }

    public function findByIds(array $ids): array
    {
        if (empty($ids)) {
            return [];
        }

        // Подготовим placeholders (?, ?, ?) и массив параметров
        $placeholders = R::genSlots($ids);
        $sql = "id IN ($placeholders) ORDER BY id DESC";

        return R::find('brands', $sql, $ids);
    }

    public function countAll(): int
    {
        return R::count('brands');
    }

    public function save(Brand $brand): int
    {
        $bean = R::dispense('brands');

        $bean->title = $brand->title;

        return (int) R::store($bean);
    }

    public function getBrands (): array
    {

    }



    // public function findAll(): array
    // {
    //     $beans = R::findAll('categories', 'ORDER BY id DESC');
    //     return array_map([$this, 'mapBeanToCategory'], $beans);
    // }

    // public function findByIds(array $ids): array
    // {
    //     if (empty($ids)) {
    //         return [];
    //     }

    //     $placeholders = R::genSlots($ids);
    //     $sql = "id IN ($placeholders) ORDER BY id DESC";

    //     $beans = R::find('categories', $sql, $ids);
    //     return array_map([$this, 'mapBeanToCategory'], $beans);
    // }

    public function getMainCats(): array
    {
        return $this->findCatsByParentId();
    }

    public function getSubCats(): array
    {
        $beans = R::findAll('categories', 'parent_id IS NOT NULL');
        return array_map([$this, 'mapBeanToCategory'], $beans);
    }

    public function findCatsByParentId(?int $parentId = null): array
    {
        if ($parentId === null) {
            $beans = R::findAll('categories', 'parent_id IS NULL');
        } else {
            $beans = R::findAll('categories', 'parent_id = ?', [$parentId]);
        }

        return array_map([$this, 'mapBeanToCategory'], $beans);
    }

    // public function countAll(): int
    // {
    //     return R::count('categories');
    // }

    // public function save(Category $cat): int
    // {
    //     $bean = $cat->getId() ? R::load('categories', $cat->getId()) : R::dispense('categories');

    //     $bean->title = $cat->getTitle(); // по умолчанию ru
    //     $bean->parent_id = $cat->getParentId();
    //     $bean->image = $cat->getImage();
    //     $bean->seo_title = $cat->getSeoTitle();
    //     $bean->seo_description = $cat->getSeoDescription();

    //     $id = (int) R::store($bean);

    //     // Сохраняем переводы в отдельную таблицу
    //     R::exec('DELETE FROM categories_translation WHERE category_id = ?', [$id]);
    //     foreach ($cat->getAllTranslations() as $locale => $translation) {
    //         $transBean = R::dispense('categories_translation');
    //         $transBean->category_id = $id;
    //         $transBean->locale = $locale;
    //         $transBean->title = $translation['title'] ?? '';
    //         $transBean->description = $translation['description'] ?? '';
    //         $transBean->meta_title = $translation['meta_title'] ?? '';
    //         $transBean->meta_description = $translation['meta_description'] ?? '';
    //         R::store($transBean);
    //     }

    //     return $id;
    // }

    // /**
    //  * Загружает переводы из categories_translation
    //  */
    // private function loadTranslations(int $categoryId): array
    // {
    //     $rows = R::getAll(
    //         'SELECT locale, title, description, meta_title, meta_description FROM categories_translation WHERE category_id = ?',
    //         [$categoryId]
    //     );

    //     $translations = [];
    //     foreach ($rows as $row) {
    //         $translations[$row['locale']] = [
    //             'title' => $row['title'],
    //             'description' => $row['description'],
    //             'meta_title' => $row['meta_title'],
    //             'meta_description' => $row['meta_description'],
    //         ];
    //     }

    //     return $translations;
    // }

    

    

}
