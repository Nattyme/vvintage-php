<?php
require_once ROOT . "./libs/functions.php";

$pagination = pagination($settings['card_on_page_shop'], 'products', [' subcat = ? ', [$uriGetParam]]);
$productsDB = R::findLike('products', ['subcat' => [$uriGetParam]], 'ORDER BY id DESC ' . $pagination['sql_page_limit']); 

$products = array();
foreach ($productsDB as $current_product) {
  // Получаем  текущую секцию для записи в БД
  $currentSection = $uriModule;

  // Узнаем категорию по GET запросу
  $categories = R::find('categories', ' section LIKE ? ', [$currentSection]);

  $brands = R::find('brands');
  if($current_product['subcat'] === $uriGetParam) {
    $product['id'] = $current_product->id;
    $product['title'] = $current_product->title;
    $product['brand'] = $current_product->brand;
    $product['cat'] = $current_product->cat;
    $product['cover_small'] = $current_product->cover_small;
    $product['price'] =$current_product->price;
    if (isset($current_product['cat']) && !empty($current_product['cat']) && $current_product['cat'] === $categories[$current_product['cat']]['id']) {
      $current_product['cat'] = $categories[$current_product['cat']]['title'];
    }
    if ( isset($current_product['brand']) 
          && !empty($current_product['brand']) && $current_product['brand'] === $brands[$current_product['brand']]['id']) {
      $current_product['brand'] = $brands[$current_product['brand']]['title'];
    }
    $product['cat_title'] = $current_product['cat'];
    $product['brand_title'] = $current_product['brand'];
    
    $products[] = $product;
  } 
}

$pageTitle = "Каталог товаров";

// Подключение шаблонов страницы
include ROOT . "templates/page-parts/_head.tpl";
include ROOT . "templates/_parts/_header.tpl";
include ROOT . "templates/shop/catalog.tpl";
include ROOT . "templates/_parts/_footer.tpl";
include ROOT . "templates/page-parts/_foot.tpl";