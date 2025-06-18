<?php 
declare(strict_types=1);
namespace Vvintage\Models\Shop;

require_once ROOT . "./libs/functions.php";


class Product 
{
      private int $id;
      private string $title;
      private string $content;
      private string $brand;
      private string $category;
      private float $price;
      private string $timestamp;

      public static function findById (int $id) : ?self
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

          $product = new self();
          $product->id = $row['id'];
          $product->title = $row['title'];
          $product->content = $row['content'];
          $product->category = $row['category'];
          $product->price = (float)$row['price'];
          $product->timestamp = $row['timestamp'];

          return $product;
      }

      public function getImages(): array 
      {
          // Запрашиваем информацию по тзображениям
          $sqlQuery = 'SELECT pi.filename, pi.image_order 
              FROM `productimages` pi
              WHERE product_id = ?
              ORDER BY image_order ASC'; 
  
          $row = R::getAll($sqlQuery, [$this->id]);

          $main = null;
          $others = [];

          // Обходим массив изображении продукта и находим главное. Остальные сохраняем в массив
          foreach ($row as $field) 
          {
                if ((int) $field['image_order'] === 1 && $main === null) {
                  $main = $field['filename'];
                } else {
                  $others[] = $field['filename'];
                }
          }

          return ['main' => $main, 'others' => $others];
      }

      // Ф-ция возвращает похожие продукты
      public function getRelated(): array
      {
            return get_related_products($this->title, $this->brand, $this->category);
      }

      public function getTitle(): string 
      {
            return $this->title;
      }
}