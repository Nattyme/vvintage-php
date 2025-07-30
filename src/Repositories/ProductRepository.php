<?php

declare(strict_types=1);

namespace Vvintage\Repositories;

use RedBeanPHP\R;
use Vvintage\Models\Shop\Product;
use Vvintage\DTO\Product\ProductDTO;

final class ProductRepository
{
    public function findAll(array $pagination = []): array
    {
        $rows = $this->uniteProductBeanData(); // без аргумента — возвращает список
        dd($rows);
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

    // Ищет продукт по id
    public function findById(int $id): ?Product
    {
        $bean = $this->uniteProductBeanData($id);
        return $bean ? $this->mapBeanToProduct($bean) : null;
    }


    private function uniteProductBeanData(?int $productId = null): array|OODBBean|null
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
              c.title AS category_title,
              GROUP_CONCAT(DISTINCT pi.filename ORDER BY pi.image_order) AS images
          FROM products p
          LEFT JOIN products_translation pt ON pt.product_id = p.id AND pt.locale = ?
          LEFT JOIN productimages pi ON pi.product_id = p.id
          LEFT JOIN brands b ON p.brand_id = b.id
          LEFT JOIN categories c ON p.category_id = c.id
      ';

      $locale = 'ru';
      $bindings = [$locale];

      if ($productId !== null) {
          $sql .= ' WHERE p.id = ? GROUP BY p.id LIMIT 1';
          $bindings[] = $productId;
          return R::getRow($sql, $bindings);
      } else {
          $sql .= ' GROUP BY p.id ORDER BY p.id DESC';
          dd(R::getAll($sql, $bindings));
          return R::getAll($sql, $bindings);
      }


        $locale = 'ru'; // Пока статично, позже сделаем динамически

        $bindings = [$locale];

        if ($productId !== null) {
            $sql .= ' WHERE p.id = ? GROUP BY p.id LIMIT 1';
            $bindings[] = $productId;
            return R::getRow($sql, $bindings);
        } else {
            $sql .= ' GROUP BY p.id ORDER BY p.id DESC';
            dd(R::getAll($sql, $bindings));
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

    private function mapBeanToProduct(array $bean): Product
    {
        $translations = $this->loadTranslations((int) $bean['id']);

        $dto = new ProductDTO([
            'id' => (int) $bean['id'],
            'category_id' => (int) $bean['category_id'],
            'brand_id' => (int) $bean['brand_id'],
            'slug' => (string) $bean['slug'],
            'title' => (string) $bean['title'],
            'content' => (string) $bean['content'],
            'price' => (int) $bean['price'],
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
