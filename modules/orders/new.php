<?php
// Подключаем readbean
use RedBeanPHP\R;

require_once ROOT . './libs/functions.php';
$uriModule = getModuleName();

if (isset($_POST['submit'])) {
  // Проверка токена
  if (!check_csrf($_POST['csrf'] ?? '')) {
    $_SESSION['errors'][] = ['error', 'Неверный токен безопасности'];
  }
  
  // Проверка если поля пустые
  if  ( empty(trim($_POST['name'])) ) {
    $_SESSION['errors'][] = ['title' => 'Поле "имя" пустое. Заполните данные для отправки.'];
  } 

  if ( empty(trim($_POST['surname'])) ) {
    $_SESSION['errors'][] = ['title' => 'Поле "фамилия" пустое. Заполните данные для отправки.'];
  }

  if ( empty(trim($_POST['email'])) ) {
    $_SESSION['errors'][] = ['title' => 'Поле "email" пустое. Заполните данные для отправки.'];
  }

  if ( empty(trim($_POST['phone'])) ) {
    $_SESSION['errors'][] = ['title' => 'Поле "телефон" пустое. Заполните данные для отправки.'];
  }

  if ( empty(trim($_POST['address'])) ) {
    $_SESSION['errors'][] = ['title' => 'Поле "адрес" пустое. Заполните данные для отправки.'];
  } 

  // Если массив ошибок пуст
  if ( empty($_SESSION['errors'])) {
    $order = R::dispense('orders');
    $order->name = htmlentities(trim($_POST['name']));
    $order->surname = htmlentities(trim($_POST['surname']));
    $order->email = filter_var(htmlentities(trim($_POST['email'])), FILTER_VALIDATE_EMAIL);
    $order->phone = trim($_POST['phone']);
    $order->address = htmlentities(trim($_POST['address']));
    $order->timestamp = time();
    $order->status = 'new';
    $order->paid = false;

    $order->cart = json_encode($cart);

    // Если пользователь вошел в профиль
    if ( isLoggedIn() ) { $order->user = $_SESSION['logged_user']; }

    $order_cart = array();
    $total_price = 0;

    foreach ($cart as $key => $value) {
      $current_item = array();

      $current_item['id'] = $key;
      $current_item['amount'] = $value;

      $product = R::load('products', $key); 
      $current_item['title'] = $product['title'];
      $current_item['price'] = $product['price'];
      
      $total_price = $total_price + ( $product['price'] * $value );

      $order_cart[] = $current_item;
    }

    $order->price = $total_price;
    $order->cart = json_encode($order_cart);
    // Сохраняем заказ
    $new_order_id = R::store($order);

    // Очищаем корзину
    if ( isLoggedIn() ) {
      $_SESSION['cart'] = array();
      $_SESSION['logged_user']->cart = '';

      R::store($_SESSION['logged_user']);

    } else {
      setcookie('cart', '', time() - 3600);
    }

    header('Location: ' . HOST . 'ordercreated?id=' . $new_order_id);
    exit();

  }
}

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

$pageTitle = "Оформление нового заказа";

// Хлебные крошки
$breadcrumbs = [
  ['title' => 'Оформление заказа', 'url' => '#!'],
];

include ROOT . "templates/_page-parts/_head.tpl";
include ROOT . "templates/_parts/_header.tpl";
include ROOT . "templates/orders/new.tpl";
include ROOT . "templates/_parts/_footer.tpl";
include ROOT . "templates/_page-parts/_foot.tpl";