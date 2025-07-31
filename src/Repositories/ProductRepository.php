<?php

declare(strict_types=1);

namespace Vvintage\Repositories;

use RedBeanPHP\R;
use Vvintage\Models\Shop\Product;
use Vvintage\DTO\Product\ProductDTO;
use Vvintage\Models\Category\Category;
use Vvintage\DTO\Category\CategoryDTO;

final class ProductRepository
{
    public function findAll(array $pagination = []): array
    {
        $rows = $this->uniteProductBeanData();
        return array_map([$this, 'mapBeanToProduct'], $rows);
    }

    public function findByIds(array $ids): array
    {
        if (empty($ids)) {
            return [];
        }

        $products = [];
        foreach ($ids as $id) {
            $bean = $this->uniteProductBeanData($id);
            if ($bean) {
                $products[] = $this->mapBeanToProduct($bean);
            }
        }

        return $products;
    }

    public function findById(int $id): ?Product
    {
        $bean = $this->uniteProductBeanData($id);
        return $bean ? $this->mapBeanToProduct($bean) : null;
    }

    private function uniteProductBeanData(?int $productId = null): array|\RedBeanPHP\OODBBean|null
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
            return R::getRow($sql, $bindings);
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

    private function createCategoryDTOFromBean(array $bean): CategoryDTO
    {
        $locale = $bean['locale'] ?? 'ru';

        return new CategoryDTO([
            'id' => (int) $bean['category_id'],
            'title' => (string) ($bean['category_title_translation'] ?? ''),
            'parent_id' => (int) ($bean['category_parent_id'] ?? 0),
            'image' => (string) ($bean['category_image'] ?? ''),
            'translations' => [
                $locale => [
                    'title' => $bean['category_title_translation'] ?? '',
                    'description' => $bean['category_description'] ?? '',
                    'seo_title' => $bean['category_meta_title'] ?? '',
                    'seo_description' => $bean['category_meta_description'] ?? '',
                ]
            ],
            'seoTitle' => $bean['category_meta_title'] ?? '',
            'seoDescription' => $bean['category_meta_description'] ?? '',
            'locale' => $locale,
        ]);

        // return Category::fromDTO($dto);
    }

    private function mapBeanToProduct(array $bean): Product
    {
        $translations = $this->loadTranslations((int) $bean['id']);
        $categoryDTO = $this->createCategoryDTOFromBean($bean);

        $dto = new ProductDTO([
            'id' => (int) $bean['id'],
            'category_id' => $bean['category_id'],
            'categoryDTO' => $categoryDTO,
            'brand_id' => (int) $bean['brand_id'],
            'brand_title' => (string) $bean['brand_title'],
            'slug' => (string) $bean['slug'],
            'title' => (string) $bean['title'],
            'content' => (string) $bean['content'],
            'price' => (string) $bean['price'],
            'url' => (string) $bean['url'],
            'article' => (string) $bean['article'],
            'stock' => (int) $bean['stock'],
            'datetime' => (string) $bean['datetime'],
            'images' => $bean['images'],
            'images_total' => isset($bean['images']) ? count(explode(',', $bean['images'])) : 0,
            'translations' => $translations,
            'seo_title' => $bean['seo_title'] ?? '',
            'seo_description' => $bean['seo_description'] ?? '',
            'locale' => $bean['locale'] ?? 'ru',
        ]);

        return Product::fromDTO($dto);
    }

    public function countAll(): int
    {
        return (int) R::count('products');
    }
}
