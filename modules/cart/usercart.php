<?php
// Определяем корзину
$cart = array();
if ( isLoggedIn() && isset($_SESSION['cart'])) {
  $cart = $_SESSION['cart'];
} else if ( isset($_COOKIE['cart']) && !empty($_COOKIE['cart']) ) {
  $cart = json_decode($_COOKIE['cart'], true);
}

// Определяем счетчик товаров в корзине
$cartCount = array_sum($cart);