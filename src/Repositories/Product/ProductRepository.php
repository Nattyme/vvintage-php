<?php

declare(strict_types=1);

namespace Vvintage\Repositories\Product;

use RedBeanPHP\R;

/** Контракты */
use Vvintage\Contracts\Product\ProductRepositoryInterface;

use Vvintage\Repositories\AbstractRepository;

/** Модели */
use Vvintage\Models\Shop\Product;
use Vvintage\Models\Category\Category;
use Vvintage\Models\Brand\Brand;

/** DTO */
use Vvintage\DTO\Product\ProductDTO;
use Vvintage\DTO\Product\ProductImageDTO;
use Vvintage\DTO\Category\CategoryDTO;
use Vvintage\DTO\Brand\BrandDTO;

final class ProductRepository extends AbstractRepository implements ProductRepositoryInterface
{
    private const TABLE_PRODUCTS = 'products';
    private const TABLE_PRODUCTS_TRANSLATION = 'products_translation';
    private const TABLE_PRODUCT_IMAGES = 'productimages';

    private const TABLE_BRANDS = 'brands';
    private const TABLE_BRANDS_TRANSLATION = 'brands_translation';

    private const TABLE_CATEGORIES = 'categories';
    private const TABLE_CATEGORIES_TRANSLATION = 'categories_translation';

    private const DEFAULT_LOCALE = 'ru';
            
           
    public function getProductById(int $id): ?Product
    {
        $rows = $this->uniteProductRawData($id);
        return $rows ? $this->fetchProductWithJoins($rows[0]) : null;
    }

    public function getAllProducts(array $pagination = []): array
    {
        $rows = $this->uniteProductRawData();
        return array_map([$this, 'fetchProductWithJoins'], $rows);
    }

    public function getProductsByIds(array $ids): array
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
                c.id AS category_id,
                c.title AS category_title,
                c.parent_id AS category_parent_id,
                c.image AS category_image,
                ct.title AS category_title_translation,
                ct.description AS category_description,
                ct.meta_title AS category_meta_title,
                ct.meta_description AS category_meta_description,
                b.id AS brand_id,
                b.title AS brand_title,
                b.image AS brand_image,
                bt.title AS brand_title_translation,
                bt.description AS brand_description,
                bt.meta_title AS brand_meta_title,
                bt.meta_description AS brand_meta_description,
                GROUP_CONCAT(DISTINCT pi.filename ORDER BY pi.image_order) AS images
            FROM ' . self::TABLE_PRODUCTS .' p
            LEFT JOIN ' . self::TABLE_PRODUCTS_TRANSLATION .' pt ON pt.product_id = p.id AND pt.locale = ?
            LEFT JOIN ' . self::TABLE_PRODUCT_IMAGES .' pi ON pi.product_id = p.id
            LEFT JOIN ' . self::TABLE_CATEGORIES .' c ON p.category_id = c.id
            LEFT JOIN ' . self::TABLE_CATEGORIES_TRANSLATION . ' ct ON ct.category_id = c.id AND ct.locale = ?
            LEFT JOIN ' . self::TABLE_BRANDS . ' b ON p.brand_id = b.id
            LEFT JOIN ' . self::TABLE_BRANDS_TRANSLATION . ' bt ON bt.brand_id = b.id AND bt.locale = ?
        ';

        $locale = self::DEFAULT_LOCALE;
        $bindings = [$locale, $locale, $locale];

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
             FROM ' . self::TABLE_PRODUCTS_TRANSLATION .' 
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
        $locale = $row['locale'] ?? self::DEFAULT_LOCALE;

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
            'locale' => $locale,
        ]);
    }

    private function createBrandDTOFromArray(array $row): BrandDTO
    {
        $locale = $row['locale'] ?? self::DEFAULT_LOCALE;

        return new BrandDTO([
            'id' => (int) $row['brand_id'],
            'title' => (string) ($row['brand_title_translation'] ?? ''),
            'image' => (string) ($row['brand_image'] ?? ''),
            'translations' => [
                $locale => [
                    'title' => $row['brand_title_translation'] ?? '',
                    'description' => $row['brand_description'] ?? '',
                    'seo_title' => $row['brand_meta_title'] ?? '',
                    'seo_description' => $row['brand_meta_description'] ?? '',
                ]
            ],
            'locale' => $locale,
        ]);
    }

    private function fetchImageDTOs(array $row): array
    {
        $imagesRows = R::getAll(
            'SELECT id, product_id, filename, image_order 
            FROM ' . self::TABLE_PRODUCT_IMAGES . '
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
        $brandDTO = $this->createBrandDTOFromArray($row);
        $imagesDTO = $this->fetchImageDTOs($row);

        $dto = new ProductDTO([
            'id' => (int) $row['id'],
            'categoryDTO' => $categoryDTO,
            'brandDTO' => $brandDTO,
            'slug' => (string) $row['slug'],
            'title' => (string) $row['title'],
            'content' => (string) $row['content'],
            'price' => (string) $row['price'],
            'url' => (string) $row['url'],
            'sku' => (string) $row['sku'],
            'stock' => (int) $row['stock'],
            'datetime' => (string) $row['datetime'],
            'images_total' => count($imagesDTO),
            'translations' => $translations,
            'locale' => $row['locale'] ?? self::DEFAULT_LOCALE,
            'images' => $imagesDTO,
        ]);

        return Product::fromDTO($dto);
    }

    public function getAllProductsCount(?string $sql = null, array $params = []): int
    {
      return $this->countAll(self::TABLE_PRODUCTS, $sql, $params);
    }

}
