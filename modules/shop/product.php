<?php 
require_once ROOT . "./libs/functions.php";

// Показываем отдельную страницу товара
$sqlQuery = 'SELECT
                products.id, products.title, products.content, products.cover, products.timestamp, 
                products.brand, products.cat, products.price, products.brand,
                categories.title AS cat_title,
                brands.title AS brand_title
             FROM `products`
             LEFT JOIN `categories` ON products.cat = categories.id
             LEFT JOIN `brands` ON products.brand = brands.id
             WHERE products.id = ? LIMIT 1';

$product = R::getRow($sqlQuery, [$uriGet]);


// // Комментарии
// $sqlQueryComments = 'SELECT 
//                         comments.text, comments.user, comments.timestamp,
//                         users.id, users.name, users.surname, users.avatar_small
//                      FROM `comments`
//                      LEFT JOIN `users` ON comments.user = users.id
//                      WHERE comments.post = ?';

// $comments = R::getAll( $sqlQueryComments, [$post['id']] );

// // Вывод похожих товаров
// $relatedProducts = get_related_products($product['title'], $product['brand'], $product['cat']);

// $pageTitle = "Название товара {$product['title']}";
// Подключение шаблонов страницы
include ROOT . "templates/_page-parts/_head.tpl";
include ROOT . "templates/_parts/_header.tpl";
include ROOT . "templates/shop/product.tpl";
include ROOT . "templates/_parts/_footer.tpl";
include ROOT . "templates/_page-parts/_foot.tpl";