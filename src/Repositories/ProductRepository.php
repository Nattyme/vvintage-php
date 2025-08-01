<?php

declare(strict_types=1);

namespace Vvintage\Repositories;

use RedBeanPHP\R;
use Vvintage\Models\Shop\Product;
use Vvintage\DTO\Product\ProductDTO;
use Vvintage\DTO\Product\ProductImageDTO;
use Vvintage\Models\Category\Category;
use Vvintage\DTO\Category\CategoryDTO;

final class ProductRepository
{
  
    public function findById(int $id): ?Product
    {
        $rows = $this->uniteProductRawData($id);
        return $rows ? $this->fetchProductWithJoins($rows[0]) : null;
    }

    public function findAll(array $pagination = []): array
    {
        $rows = $this->uniteProductRawData();
        return array_map([$this, 'fetchProductWithJoins'], $rows);
    }

    public function findByIds(array $ids): array
    {
        if (empty($ids)) {
            return [];
        }

        $products = [];
        foreach ($ids as $id) {
            $bean = $this->uniteProductRawData($id);
            if ($bean) {
                $products[] = $this->fetchProductWithJoins($bean);
            }
        }

        return $products;
    }


    private function uniteProductRawData(?int $productId = null): array
    {
        $sql = '
            SELECT 
                p.*,
                pt.locale,
                pt.title,
                pt.description,
                pt.meta_title,
                pt.meta_description,
                b.title AS brand_title,
                c.id AS category_id,
                c.title AS category_title,
                c.parent_id AS category_parent_id,
                c.image AS category_image,
                ct.title AS category_title_translation,
                ct.description AS category_description,
                ct.meta_title AS category_meta_title,
                ct.meta_description AS category_meta_description,
                GROUP_CONCAT(DISTINCT pi.filename ORDER BY pi.image_order) AS images
            FROM products p
            LEFT JOIN products_translation pt ON pt.product_id = p.id AND pt.locale = ?
            LEFT JOIN productimages pi ON pi.product_id = p.id
            LEFT JOIN brands b ON p.brand_id = b.id
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN categories_translation ct ON ct.category_id = c.id AND ct.locale = ?
        ';

        $locale = 'ru';
        $bindings = [$locale, $locale];

        if ($productId !== null) {
            $sql .= ' WHERE p.id = ? GROUP BY p.id LIMIT 1';
            $bindings[] = $productId;
            // ⬇Заворачиваем в массив
            $row = R::getRow($sql, $bindings);
            return $row ? [$row] : [];
        } else {
            $sql .= ' GROUP BY p.id ORDER BY p.id DESC';
            return R::getAll($sql, $bindings);
        }
    }


    private function loadTranslations(int $productId): array
    {
        $rows = R::getAll(
            'SELECT locale, title, description, meta_title, meta_description 
             FROM products_translation 
             WHERE product_id = ?',
            [$productId]
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

    private function createCategoryDTOFromArray(array $row): CategoryDTO
    {
        $locale = $row['locale'] ?? 'ru';

        return new CategoryDTO([
            'id' => (int) $row['category_id'],
            'title' => (string) ($row['category_title_translation'] ?? ''),
            'parent_id' => (int) ($row['category_parent_id'] ?? 0),
            'image' => (string) ($row['category_image'] ?? ''),
            'translations' => [
                $locale => [
                    'title' => $row['category_title_translation'] ?? '',
                    'description' => $row['category_description'] ?? '',
                    'seo_title' => $row['category_meta_title'] ?? '',
                    'seo_description' => $row['category_meta_description'] ?? '',
                ]
            ],
            'seoTitle' => $row['category_meta_title'] ?? '',
            'seoDescription' => $row['category_meta_description'] ?? '',
            'locale' => $locale,
        ]);
    }

    private function fetchImageDTOs(array $row): array
    {
        $imagesRows = R::getAll(
            'SELECT id, product_id, filename, image_order 
            FROM productimages 
            WHERE product_id = ? 
            ORDER BY image_order',
            [$row['id']]
        );

        return array_map(fn($imageRow) => new ProductImageDTO($imageRow), $imagesRows);
    }

    private function fetchProductWithJoins(array $row): Product
    {
        $productId = (int) $row['id'];

        $translations = $this->loadTranslations($productId);
        $categoryDTO = $this->createCategoryDTOFromArray($row);
        $imagesDTO = $this->fetchImageDTOs($row);

        $dto = new ProductDTO([
            'id' => (int) $row['id'],
            'category_id' => (int) $row['category_id'],
            'category_title' => (string) $row['category_title'],
            'categoryDTO' => $categoryDTO,
            'brand_id' => (int) $row['brand_id'],
            'brand_title' => (string) $row['brand_title'],
            'slug' => (string) $row['slug'],
            'title' => (string) $row['title'],
            'content' => (string) $row['content'],
            'price' => (string) $row['price'],
            'url' => (string) $row['url'],
            'article' => (string) $row['article'],
            'stock' => (int) $row['stock'],
            'datetime' => (string) $row['datetime'],
            'images' => $imagesDTO,
            'images_total' => count($imagesDTO),
            'translations' => $translations,
            'seo_title' => $row['seo_title'] ?? '',
            'seo_description' => $row['seo_description'] ?? '',
            'locale' => $row['locale'] ?? 'ru',
        ]);

        return Product::fromDTO($dto);
    }


    public function countAll(): int
    {
        return (int) R::count('products');
    }
}
