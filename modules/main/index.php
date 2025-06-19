<?php
// Подключаем readbean
use RedBeanPHP\R;

require_once ROOT . './libs/functions.php';
$uriModule = getModuleName();

$pageTitle = 'Vvintage - интернет магазин. Главная страница';

// Получим категории
$categories = R::find('categories', 'parent_id IS NULL');

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

// Получаем найстройки для главной страницы из БД
$settingsMain = R::find('settings', ' section LIKE ? ', ['main']); 

// Формируем массив
$main = [];
foreach ($settingsMain as $key => $value) {
  $main[$value['name']] = $value['value'];
}

// Делаем запрос в БД для получения постов
$posts = R::find('posts', "ORDER BY id DESC LIMIT 4");

include ROOT . "templates/_page-parts/_head.tpl";
include ROOT . "templates/_parts/_header.tpl";
include ROOT . "templates/main/main.tpl";
include ROOT . "templates/_parts/_footer.tpl";
include ROOT . "templates/_page-parts/_foot.tpl";