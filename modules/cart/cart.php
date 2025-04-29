<?php 
// Получаем товары, которые соответствуют товарам в корзине
if ( !empty($cart) ) {
  $products = R::findLike ('products', ['id' => array_keys($cart)]); 
  // R::findLike('products', ['id' => ['5', '2']])
} else {
  $products = array();
}

// Общая стоимость товаров в корзине
$cartTotalPrice = 0;
foreach ( $cart as $index => $item) {
  $cartTotalPrice = $cartTotalPrice + $products[$index]['price'] * $item;
}

$pageTitle = "Корзина товаров";
// Подключение шаблонов страницы
include ROOT . "templates/_page-parts/_head.tpl";
include ROOT . "templates/_parts/_header.tpl";
include ROOT . "templates/cart/cart.tpl";
include ROOT . "templates/_parts/_footer.tpl";
include ROOT . "templates/_page-parts/_foot.tpl";