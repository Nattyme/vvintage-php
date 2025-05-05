<?php
require_once ROOT . './libs/functions.php';
$uriModule = getModuleName();

// Получим категории
$sqlCats = 'SELECT c.id,
                   c.title,
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

$pageTitle = 'Womazing';

include ROOT . "templates/_page-parts/_head.tpl";

if(isset($_SESSION['logged_user']) && trim($_SESSION['logged_user']) !== '') {
  include ROOT . "templates/_parts/_admin-panel.tpl";
} 


include ROOT . "templates/_parts/_header.tpl";
include ROOT . "templates/main/main.tpl";
include ROOT . "templates/_parts/_footer.tpl";
include ROOT . "templates/_page-parts/_foot.tpl";