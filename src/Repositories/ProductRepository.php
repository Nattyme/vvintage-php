<?php

declare(strict_types=1);

namespace Vvintage\Repositories;

use RedBeanPHP\R; // Подключаем readbean
use Vvintage\Models\Shop\Product;

final class ProductRepository
{
    public static function findById(int $id): ?Product
    {
        // Запрашиваем информацию по продукту
      $sqlQuery = 'SELECT
        p.id, 
        p.title, 
        p.content, 
        p.datetime,
        p.price, 
        p.brand, 
        p.category, 
        c.title AS cat_title,
        b.title AS brand_title
        FROM `products` p
        LEFT JOIN `categories` c ON  p.category = c.id
        LEFT JOIN `brands` b ON p.brand = b.id
        WHERE p.id = ? LIMIT 1
      ';
        $row = R::getRow($sqlQuery, [$id]);

        if (!$row) {
            return null;
        }

        $product = new Product();
        $product->loadFromArray($row);
        return $product;
    }

    public static function findAll(array $pagination): array
    {
        $sqlQuery = 'SELECT
                p.id, 
                p.title, 
                p.article, 
                p.price, 
                p.url, 
                p.datetime,
                b.title AS brand, 
                c.title AS category,
                pi.filename 
                
            FROM `products` p
            LEFT JOIN `brands` b ON p.brand = b.id
            LEFT JOIN `categories` c ON p.category = c.id
            LEFT JOIN (
              SELECT product_id, filename
              FROM productimages 
              WHERE image_order = 1
            ) pi ON p.id = pi.product_id
            ORDER BY p.id DESC ' . $pagination["sql_page_limit"];

        $rows = R::getAll($sqlQuery);

        $products = [];

        foreach ($rows as $row) {
            $product = new Product();
            $product->loadFromArray($row);
            $products[] = $product;
        }

        return $products;
    }

    public static function findByIds(array $ids): array
    {
        $idsData = array_keys($ids);

        // Плейсхолдеры для запроса
        $slotString = R::genSlots($idsData);

        // Находим продукты и их главное изображение
        $sql = "SELECT 
                  p.id,
                  p.title,
                  p.article, 
                  p.category,
                  p.brand,
                  p.price,
                  pi.filename,
                  pi.filename_small
            FROM `products` p 
            LEFT JOIN `productimages` pi ON p.id = pi.product_id AND pi.image_order = 1
            WHERE p.id IN ($slotString)";

        $productsData = R::getAll($sql, $idsData);
        $products = [];

        foreach ($productsData as $key => $value) {
            $products[$value['id']] = $value;
        }

        return $products;
    }
}
