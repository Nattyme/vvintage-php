<?php

declare(strict_types=1);

namespace Vvintage\Repositories;

use Vvintage\Models\Product\Product;
use RedBeanPHP\R;

final class ProductRepository
{
    public static function findById(int $id): ?Product
    {
        $sql = 'SELECT 
            p.*, 
            c.title AS cat_title,
            b.title AS brand_title
            FROM products p
            LEFT JOIN categories c ON p.category = c.id
            LEFT JOIN brands b ON p.brand = b.id
            WHERE p.id = ? LIMIT 1';

        $row = R::getRow($sql, [$id]);
        if (!$row) return null;

        $images = self::getProductImages($id);
        $translationsData = self::getProductTranslations($id, 'ru');

        $data = array_merge($row, [
            'images' => $images['images'],
            'imagesTotal' => $images['total'],
            'translations' => $translationsData['translations'],
            'seo_title' => $translationsData['seoTitle'],
            'seo_description' => $translationsData['seoDescription'],
            'locale' => 'ru',
        ]);

        return Product::fromArray($data);
    }

    private static function getProductImages(int $productId): array
    {
        $images = R::getAll(
            'SELECT filename, image_order FROM productimages WHERE product_id = ? ORDER BY image_order ASC',
            [$productId]
        );

        $main = null;
        $others = [];

        foreach ($images as $img) {
            if ((int)$img['image_order'] === 1 && $main === null) {
                $main = $img['filename'];
            } else {
                $others[] = $img['filename'];
            }
        }

        return [
            'images' => ['main' => $main, 'others' => $others],
            'total' => count($images),
        ];
    }

    private static function getProductTranslations(int $productId, string $locale): array
    {
        $translations = R::getAll(
            'SELECT locale, title, seo_title, seo_description FROM products_translations WHERE product_id = ?',
            [$productId]
        );

        $translationsArray = [];
        $seoTitle = '';
        $seoDescription = '';

        foreach ($translations as $trans) {
            $translationsArray[$trans['locale']] = [
                'title' => $trans['title'],
                'seo_title' => $trans['seo_title'],
                'seo_description' => $trans['seo_description'],
            ];

            if ($trans['locale'] === $locale) {
                $seoTitle = $trans['seo_title'];
                $seoDescription = $trans['seo_description'];
            }
        }

        return [
            'translations' => $translationsArray,
            'seoTitle' => $seoTitle,
            'seoDescription' => $seoDescription,
        ];
    }
}
