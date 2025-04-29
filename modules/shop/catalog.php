<?php 
require_once ROOT . "./libs/functions.php";
$uriModule = getModuleName();
$uriGet = getUriGet();
$uriGetParam = getUriGetParam();

// $pagination = pagination($settings['card_on_page_shop'], 'products');
$pagination = pagination(9, 'products');

$sqlQuery = 'SELECT
                p.id, p.title, p.content, p.cover, p.timestamp, 
                p.brand, p.cat, p.price, p.brand, s.cover AS product_cover, s.id, s.cover_small AS product_coverSmall,
                s.cover_full AS product_coverFull, s.product_id AS product_id
             FROM `products` as p
             LEFT JOIN `sliders` as s ON p.id = product_id';
// $sqlQuery = 'SELECT
//                 p.id, p.title, p.content, p.cover, p.timestamp, 
//                 p.brand, p.cat, p.price, p.brand
//              FROM `products` as p
//              LEFT JOIN (
//                 SELECT s.cover AS product_cover, s.id, s.cover_small AS product_coverSmall,
//                 s.cover_full AS product_coverFull, s.product_id AS product_id
//                 FROM `sliders` GROUP  BY product_id  
//              ) s ON p.id = product_id'

// $sqlQueryWithLimit = $sqlQuery . $pagination["sql_page_limit"];
// $sqlQueryWithLimit = $sqlQuery . ' ' . $pagination["sql_page_limit"];


$productsDB = R::getAll($sqlQuery);
print_r($productsDB);

$pageTitle = "Каталог товаров";

// Подключение шаблонов страницы
include ROOT . 'templates/_page-parts/_head.tpl';
include ROOT . 'templates/_parts/_header.tpl';
include ROOT . 'templates/shop/catalog.tpl';
include ROOT . 'templates/_parts/_footer.tpl';
include ROOT . 'templates/_page-parts/_foot.tpl';