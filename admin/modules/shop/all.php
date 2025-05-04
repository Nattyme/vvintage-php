<?php
$pagination = pagination(8, 'products');
// $products = R::find('products', "ORDER BY id DESC {$pagination['sql_page_limit']}");

$sqlQuery = 'SELECT
                p.id, 
                p.article, 
                p.name, 
                p.price, 
                p.url, 
                b.title AS brand, 
                c.title AS category,
                pi.filename AS cover
                
             FROM `products` p
             LEFT JOIN `brands` b ON p.brand = b.id
             LEFT JOIN `categories` c ON p.category = c.id
             LEFT JOIN (
              SELECT product_id, filename
              FROM product_images 
              WHERE image_order = 1
             ) pi ON p.id = pi.product_id
             ORDER BY p.id DESC
            LIMIT 0, 8';

$products = R::getAll($sqlQuery);


$pageTitle = "Все товары";
$pageClass = "admin-page";
ob_start();
include ROOT . "admin/templates/shop/all.tpl";
$content = ob_get_contents();
ob_end_clean();

//Шаблон страницы
include ROOT . "admin/templates/template.tpl";
