<?php 
require_once ROOT . "./libs/functions.php";
$uriModule = getModuleName();
$uriGet = getUriGet();
$uriGetParam = getUriGetParam();

// $pagination = pagination($settings['card_on_page_shop'], 'products');
$pagination = pagination(9, 'products');
$showedProducts = $pagination['page_number'] * 9;
$productsTtl = R::count('products');


$sqlQuery = 'SELECT
                p.id, 
                p.article, 
                p.title, 
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

$products = R::getAll($sqlQuery);


$pageTitle = "Каталог товаров";

// Хлебные крошки
$breadcrumbs = [
  ['title' => 'Каталог', 'url' => HOST . 'shop'],
];

// Подключение шаблонов страницы
include ROOT . 'templates/_page-parts/_head.tpl';
include ROOT . 'templates/_parts/_header.tpl';
include ROOT . 'templates/shop/catalog.tpl';
include ROOT . 'templates/_parts/_footer.tpl';
include ROOT . 'templates/_page-parts/_foot.tpl';