<?php
declare(strict_types=1);

namespace Vvintage\Models\Cart;

final class Cart
{
  // Общая стоимость товаров в корзине
  private array $cart = [];
  private int $totalPrice = 0;


  private static function getUser (string $id): array
  {
    $user = R::load('users', $id);
    return $user;
  }

  public function get (bool $isLoggedIn): array
  {
    if ( $isLoggedIn ) 
    {
      // Находим пользователя в БД по id
      $user = self::getUser($_SESSION['logged_user']['id']);

      // Получаем корзину из БД
      $cart = json_decode($user->cart, true);
    } 
    
    if ( !$isLoggedIn) 
    {
       // 1. Проверить наличие корзины пользователя
      // 2. Если корзина есть - работаем с ней, если нет - создаем новую
      if (isset($_COOKIE['cart'])) {
        // Получаем корзину из COOKIE
        $cart = json_decode($_COOKIE['cart'], true);
      } else {
        $cart = array();
      }
    }

    return $cart;
  }
  
  public static function add (bool $isLoggedIn): void
  {
    if ($isLoggedIn) 
    {
      // Находим пользователя в БД по id
      $user = self::getUser($_SESSION['logged_user']['id']);     

      // Получаем корзину
      $cart = json_decode($user->cart, true) ?? [];

       // Добавляем товар в корзину
      if (isset( $cart[$_GET['id']] )) {
        // Не увеличиваем количество, если товар уже есть
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
      $_SESSION['success'][] = ['title' => 'Товар добавлен в корзину.'];

    }
     
    // Пользователь НЕ вошел в профиль
    if ( !$isLoggedIn) {
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
        // Если товар уже есть в корзине - не увеличиваем кол-во на 1
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
  }

  public static function remove (bool $isLoggedIn): void
  {
    if ( $isLoggedIn) {
      // Находим пользователя в БД по id
      $user = self::getUser($_SESSION['logged_user']['id']);

      // Получаем корзину из БД
      $cart = json_decode($user->cart, true);

      // Удаляем товар из корзины
      unset($cart[$_GET['id']]);

      // Превращаем корзину в json строку
      $user->cart = json_encode($cart);

      // Обноваляем пользователя в БД
      R::store($user);

      // Обновляем состояние корзины в сессии
      $_SESSION['cart'] = $cart;

      // Сообщение об удалении товара
      $_SESSION['success'][] = ['title' => 'Товар был удалён из корзины.'];
    }

    if ( !$isLoggedIn ) {
      if (isset($_COOKIE['cart'])) {
        // Получаем корзину из COOKIE
        $cart = json_decode($_COOKIE['cart'], true);
      } else {
        $cart = array();
      }

      // 3. Удаляем товар из корзины
      unset($cart[$_GET['id']]);

      // 4. Сохранение корзины в COOKIE
      setcookie('cart', json_encode($cart), time() + 60 * 60 * 24 * 30);

      // Сообщение об удалении товара
      $_SESSION['success'][] = ['title' => 'Товар был удалён из корзины.'];
    }

    header('Location: ' . HOST . 'cart');
    exit();
  }

  public function set (bool $isLoggedIn): array
  {
    // Определяем корзину
    if ( $isLoggedIn && isset($_SESSION['cart'])) {
      $cart = $_SESSION['cart'];
    } else if ( isset($_COOKIE['cart']) && !empty($_COOKIE['cart']) ) {
      $cart = json_decode($_COOKIE['cart'], true);
    }

    $this->cart = $cart;
    // Определяем счетчик товаров в корзине
    $cartCount = array_sum($this->cart);

    return $cart;
  }

  private function count (array $products): int
  {
    $total = 0;
    foreach ( $this->cart as $id => $quantity) {
      if(isset($products[$id])) {
        $total = $total + $products[$id]['price'] * $quantity;
      }
    }
    $this->total = $total;
    return $total;
  }

}