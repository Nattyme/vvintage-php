<?php
// Подключаем readbean
use RedBeanPHP\R;

// Пользователь выполнил вход в профиль
if ( isLoggedIn() ) {
  // Находим пользователя в БД по id
  $user = R::load('users', $_SESSION['logged_user']['id']);

  // Получаем корзину из БД
  $cart = json_decode($user->cart, true);

  // Добавляем товар в корзину
  if(isset( $cart[$_GET['id']] )) {

    // Если товар уже есть в корзине - увеличиваем кол-во на 1
    $cart[$_GET['id']] = $cart[$_GET['id']] + 1; 
  } else {

    // Формируем корзину в ассоциативный массив
    $cart[$_GET['id']] = 1;
  }

  // Превращаем корзину в json строку
  $user->cart = json_encode($cart);

  // Обновляем состояние корзины в сессии
  $_SESSION['cart'] = $cart;

  // Обноваляем пользователя в БД
  R::store($user);

  // Сообщение о добавлении товара
  // $_SESSION['success'][] = ['title' => 'Товар добавлен в корзину.'];
}

// Пользователь НЕ вошел в профиль
if ( !isLoggedIn() ) {
  // 1. Проверить наличие корзины пользователя
  // 2. Если корзина есть - работаем с ней, если нет - создаем новую
  if (isset($_COOKIE['cart'])) {
    // Получаем корзину из COOKIE
    $cart = json_decode($_COOKIE['cart'], true);
  } else {
    $cart = array();
  }
 
  // 3. Добавляем товар в корзину
  // Добавляем товар в корзину
  if(isset( $cart[$_GET['id']] )) {

    // Если товар уже есть в корзине - увеличиваем кол-во на 1
    $cart[$_GET['id']] = $cart[$_GET['id']] + 1; 
  } else {

    // Формируем корзину в ассоциативный массив
    $cart[$_GET['id']] = 1;
  }

  // 4. Сохранение корзины в COOKIE
  setcookie('cart', json_encode($cart), time() + 60 * 60 * 24 * 30);

  // 5. Сообщение о добавлении товара
  $_SESSION['success'][] = ['title' => 'Товар добавлен в корзину.'];
}

header('Location: ' . HOST . 'shop/' . $_GET['id']);
exit();