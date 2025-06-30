<?php
declare(strict_types=1);

namespace Vvintage\Models\Cart;

final class Cart
{
  // Общая стоимость товаров в корзине
  private array $cart = [];
  private int $cartTotalPrice = 0;

  public function __construct(array $cart = [])
  {
    $this->cart = $cart;
  }

  public function toArray() {
    return $this->cart;
  }


  // private static function getUser (string $id)
  // {
  //   $user = R::load('users', $id);
  //   return $user;
  // }
  // Метод получает корзину из БД или куки и записывает её в $this->cart
  /** 
   * @return array
   */
  public function getCart (bool $isLoggedIn, $user): array
  {
    if ( $isLoggedIn ) 
    {
      // Получаем корзину из БД
      $cart = $user->getCart();
      $cart = $cart->toArray();
     
    } else {

       // 1. Проверить наличие корзины пользователя
      // 2. Если корзина есть - работаем с ней, если нет - создаем новую
      if (isset($_COOKIE['cart'])) {
        // Получаем корзину из COOKIE
        $cart = json_decode($_COOKIE['cart'], true);
      } else {
        $cart = [];
      }
    }

    $this->cart = $cart;
    return $cart;
  }

  public function getQuantity ($productId): int
  {
    // Проверяем, есть ли товар в корзине
    if (isset($this->cart[$productId])) {
        return $this->cart[$productId];
    }
    return 0; // если товара нет, возвращаем 0
  }
  
  public static function addItem (bool $isLoggedIn): void
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
    // 1. Проверить наличие корзины пользователя
    // 2. Если корзина есть - работаем с ней, если нет - создаем новую
    if ( !$isLoggedIn) {
      // Получаем корзину из COOKIE
      $cart = json_decode($_COOKIE['cart'] ?? '[]', true);
    
      // 3. Добавляем товар в корзину, если его там нет
      if(! isset($cart[$_GET['id']] )) {
        // Формируем корзину в ассоциативный массив
        $cart[$_GET['id']] = 1;

        // 4. Сохранение корзины в COOKIE
        setcookie('cart', json_encode($cart), [
          'expires' => time() + 60 * 60 * 24 * 30,
          'path' => '/',
          'secure' => true, // только через HTTPS
          'httponly' => true, //Недоступно из JS
          'samesite' => 'Strict'
        ]);

        // 5. Сообщение о добавлении товара
        $_SESSION['success'][] = ['title' => 'Товар добавлен в корзину.'];

        header('Location: ' . HOST . 'shop/' . $_GET['id']);
        exit();
      } 
    }
  }

  public static function removeItem (bool $isLoggedIn): void
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

  // public function oldSet (bool $isLoggedIn): void
  // {
  //   // Определяем корзину
  //   if ( $isLoggedIn && isset($_SESSION['cart'])) {
  //     $cart = $_SESSION['cart'];
  //   } else if ( isset($_COOKIE['cart']) && !empty($_COOKIE['cart']) ) {
  //     $cart = json_decode($_COOKIE['cart'], true);
  //   }

  //   $this->cart = $cart;
  //   // Определяем счетчик товаров в корзине
  //   $cartCount = array_sum($this->cart);

  // }
  //Слияние корзины (очистка куки, сохранение новой корзины в БД и сессию)
  public function mergeCartAfterLogin (bool $isLoggedIn, $user): void
  {
    if (!$isLoggedIn || !$user) {
      // Пароль не верен
      $_SESSION['errors'][] = ['title' => 'Неверный пароль'];
      return;
    }

    // Загружаем корзину и избранное пользователя из БД 
    $temp = [
      'cart' => !empty($user->getCart()->toArray) ? json_decode($user->getCart()->toArray, true) ?? [] : [], 
      'fav_list' => []
      // 'fav_list' => !empty($user->fav_list) ? json_decode($user->fav_list, true) ?? [] : []
    ];
dd($user->getCart());
    // $_SESSION['cart'] = json_decode($_SESSION['logged_user']['cart'], true);  
    // $_SESSION['fav_list'] = json_decode($_SESSION['logged_user']['fav_list'], true);

    // Объединение содержимое куки в цикле
    foreach(['cart', 'fav_list'] as $key) {
      if ( isset($_COOKIE[$key]) && !empty($_COOKIE[$key]) ) {
        $cookieData = json_decode($_COOKIE[$key], true) ?? [];

        foreach ( $cookieData as $itemKey => $value) {
          if ( isset($temp[$key][$itemKey]) ) {
            $temp[$key][$itemKey] += $value;
          } else {
            $temp[$key][$itemKey] = $value;
          }
        }
      }
    }

    // Сохраняем в БД, очщиаем куки, обновляем сессии
    foreach ($temp as $key => $value) 
    {
      dd($temp);
      setcookie($key, '', time() - 3600, '/');
      dd($temp[$key]);
      dd($user->$key);
      $user->$key = json_encode($temp[$key]);
      $_SESSION[$key] = $temp[$key];
    }

    // Обновляем пользователя в БД
    R::store($user);

    if (isset($_SESSION['logged_user']['name']) && trim($_SESSION['logged_user']['name']) !== '') {
      $_SESSION['success'][] = ['title' => 'Здравствуйте, ' . htmlspecialchars($_SESSION['logged_user']['name']), 'desc' => 'Вы успешно вошли на сайт. Рады снова видеть вас'];
    } else {
      $_SESSION['success'][] = ['title' => 'Здравствуйте!', 'desc' => 'Вы успешно вошли на сайт. Рады снова видеть вас'];
    }

    header('Location: ' . HOST . 'profile');
    exit();
  } 


  public function countTotalPrice (array $products): int
  {
    $total = 0;
    foreach ( $this->cart as $id => $quantity) {
      if(isset($products[$id])) {
        $total = $total + $products[$id]['price'] * $quantity;
      }
    }
    $this->cartTotalPrice = $total;
    return $this->cartTotalPrice;
  }

}