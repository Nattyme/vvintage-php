<?php 
$brand = R::load('brands', $uriGetParam);
$pageTitle = "Категория: {$brand['title']}";

$pagination = pagination($settings['card_on_page_shop'], 'products', ['brand = ? ', [$uriGetParam]]);

$productsDB = R::findLike('products', ['brand' => [$uriGetParam]], 'ORDER BY id DESC ' . $pagination['sql_page_limit']); 

$products = array();
foreach ($productsDB as $current_product) {
  // Получаем строки с категориями магазина
  $categories = R::find('categories', ' section LIKE ? ', ['shop']);
 
  $brands = R::find('brands');

  $product['id'] = $current_product->id;
  $product['title'] = $current_product->title;
  $product['cat'] = $current_product->cat;
  $product['brand'] = $current_product->brand;
  $product['cover_small'] = $current_product->cover_small;
  $product['price'] = $current_product->price;
  
  if ($current_product['cat'] === $categories[$current_product['cat']]['id']) {
    $current_product['cat'] = $categories[$current_product['cat']]['title'];
  }

  if ($current_product['brand'] === $brands[$current_product['brand']]['id']) {
    $current_product['brand'] = $brands[$current_product['brand']]['title'];
  }
  $product['cat_title'] = $current_product['cat'];
  $product['brand_title'] = $current_product['brand'];
  $products [] = $product;
}

// Подключение шаблонов страницы
include ROOT . "templates/page-parts/_head.tpl";
include ROOT . "templates/_parts/_header.tpl";
include ROOT . "templates/shop/catalog.tpl";
include ROOT . "templates/_parts/_footer.tpl";
include ROOT . "templates/page-parts/_foot.tpl";