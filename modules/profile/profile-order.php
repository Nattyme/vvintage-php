<?php
// Если ID нет - выходим
if ( !isset($_GET['id']) || empty($_GET['id'])) {
  header('Location: ' . HOST . 'profile');
  exit();
}

// Если пользователь не зашел в профиль - выходим
if ( !isLoggedIn() ) {
  header('Location: ' . HOST . 'profile');
  exit();
}

// Если есть ID  - получаем данные заказа, проверяя, что это заказ вошедшего в свой профиль пользователя
$order = R::load('orders', $_GET['id']);

// Проверка, что заказ принадлежит текущему пользователю
if ( $order['user_id'] !== $_SESSION['logged_user']['id']) {
  header('Location: ' . HOST . 'profile');
  exit();
}

// Получаем массив товаров из JSON формата
$products = json_decode($order['cart'], true);

// Обходим массив с товарами и создаем новый массив с id товаров 
foreach ( $products as $product) {
  $ids[] = $product['id'];
}

// Получаем все товары с id массива $ids из таблицы 'products'
$productsDB = R::findLike('products', ['id' => $ids]);

$pageTitle = "Заказ &#8470;" . $order['id'] . "&#160; от &#160;" . rus_date('j F Y', $order['timestamp']);
$pageClass = "profile-page";

include ROOT . 'templates/page-parts/_head.tpl';
include ROOT . 'templates/_parts/_header.tpl';

include ROOT . 'templates/profile/profile-order.tpl';

include ROOT . 'templates/_parts/_footer.tpl';
include ROOT . 'templates/page-parts/_foot.tpl';