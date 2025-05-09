<?php
require_once ROOT . './libs/functions.php';
$uriModule = getModuleName();

// Получим категории
$sqlCats = 'SELECT c.id,
                   c.title,
                   c.parent_id,
                   c.image
            FROM `categories` c 
            WHERE c.parent_id IS NULL';
$categories = R::getAll($sqlCats);
// $images = [
//   1 => 'women.jpg',
//   2 => 'men.jpg',
//   3 => 'children.jpg',
//   4 => 'home.jpg',
//   5 => 'parfume.jpg',
//   6 => 'cosmetic.jpg',
//   18 => 'brands.jpg',
// ];
// foreach($categories as $category) {
//   $id = $category['id'];

//   // Проверяем , есть ли изображений для текущей категории
//   if ( isset($images[$id])) {
//     $filename = $images[$id];

//     // Обновляем поле категории
//     R::exec('UPDATE categories SET image = ? WHERE id = ?', [$filename, $id]);
//   }
// }

// Получим новинки магазина
$sqlQuery = 'SELECT
                p.id, 
                p.article, 
                p.title, 
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
              FROM productimages 
              WHERE image_order = 1
             ) pi ON p.id = pi.product_id
             ORDER BY p.id DESC
            LIMIT 4';

$newProducts = R::getAll($sqlQuery);
// print_r($newProducts);
// die();
$pageTitle = 'Womazing';

include ROOT . "templates/_page-parts/_head.tpl";

if(isset($_SESSION['logged_user']) && trim($_SESSION['logged_user']) !== '') {
  include ROOT . "templates/_parts/_admin-panel.tpl";
} 


include ROOT . "templates/_parts/_header.tpl";
include ROOT . "templates/main/main.tpl";
include ROOT . "templates/_parts/_footer.tpl";
include ROOT . "templates/_page-parts/_foot.tpl";