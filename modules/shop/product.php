<?php 
require_once ROOT . "./libs/functions.php";

// Запрашиваем информацию по продукту
$sqlQuery = 'SELECT
                p.id, 
                p.title, 
                p.content, 
                p.brand, 
                p.category, 
                p.price, 
                c.title AS cat_title,
                b.title AS brand_title
             FROM `products` p
             LEFT JOIN `categories` c ON  p.category = c.id
             LEFT JOIN `brands` b ON p.brand = b.id
             WHERE p.id = ? LIMIT 1';

$product = R::getRow($sqlQuery, [$uriGet]);

// Запрашиваем информацию по изображениям продукта
$sqlImages = 'SELECT pi.filename, pi.image_order 
              FROM productimages pi
              WHERE product_id = ?
              ORDER BY image_order ASC'; 

$productImages = R::getAll($sqlImages, [$product['id']]);

// Найдем главное изображение
$mainImage = null;
$remainingImages = [];
foreach($productImages as $value) {
  if((int)$value['image_order'] === 1 && !$mainImage) {
    $mainImage = $value['filename'];
  } else {
    $remainingImages[] = $value['filename'];
  }
}

// Найдем изображения для галлереи
$visibleImages = array_slice($remainingImages, 0, 4);
$hiddenImages = array_slice($remainingImages, 4);
$invisibleImages = [];

// // Комментарии
// $sqlQueryComments = 'SELECT 
//                         comments.text, comments.user, comments.timestamp,
//                         users.id, users.name, users.surname, users.avatar_small
//                      FROM `comments`
//                      LEFT JOIN `users` ON comments.user = users.id
//                      WHERE comments.post = ?';

// $comments = R::getAll( $sqlQueryComments, [$post['id']] );

// Вывод похожих товаров
$relatedProducts = get_related_products($product['title'], $product['brand'], $product['category']);
// print_r($relatedProducts);
// die();
$pageTitle = "Название товара {$product['title']}";
// Подключение шаблонов страницы
include ROOT . "templates/_page-parts/_head.tpl";
include ROOT . "templates/_parts/_header.tpl";
include ROOT . "templates/shop/product.tpl";
include ROOT . "templates/_parts/_footer.tpl";
include ROOT . "templates/_page-parts/_foot.tpl";