<?php
declare(strict_types=1);

namespace Vvintage\Repositories;

use RedBeanPHP\R; // Подключаем readbean
use Vvintage\Models\Shop\Product;

final class ProductRepository 
{
  public static function findById (int $id) : ?Product
  {
    // Запрашиваем информацию по продукту
    $sqlQuery = 'SELECT
        p.id, 
        p.title, 
        p.content, 
        p.brand, 
        p.category, 
        p.price, 
        p.timestamp,
        c.title AS cat_title,
        b.title AS brand_title
      FROM `products` p
      LEFT JOIN `categories` c ON  p.category = c.id
      LEFT JOIN `brands` b ON p.brand = b.id
      WHERE p.id = ? LIMIT 1
    ';
    $row = R::getRow($sqlQuery, [$id]);

    if(!$row) return null;

    $product = new Product();
    $product->loadFromArray($row);
    return $product;
  }

  public static function findAll ( array $pagination): array 
  {
    $sqlQuery = 'SELECT
                p.id, 
                p.title, 
                p.article, 
                p.price, 
                p.url, 
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

    foreach ($rows as $row) 
    {
      $product = new Product();
      $product->loadFromArray($row);
      $products[] = $product;
    }

    return $products;
  }

  public static function findByIds (array $idsData): array
  {
    // Массив ids
    $ids = array_keys($idsData);

    // Плейсхолдеры для запроса
    $slotString = R::genSlots($ids);

    // Находим продкуты и их главное изображение
    $sql = "SELECT 
                  p.id,
                  p.title,
                  p.article, 
                  p.category,
                  p.brand,
                  p.price,
                  pi.filename
            FROM `products` p 
            LEFT JOIN `productimages` pi ON p.id = pi.product_id AND pi.image_order = 1
            WHERE p.id IN ($slotString)";

      $productsData = R::getAll($sql, $ids);

      $products = [];
      foreach ($productsData as $product) {
        $id = $product['id']; // получаем id из строки
        $products[$id] = $product; // сохраняем строку под ключом id
      }

      return $products;
  }
}