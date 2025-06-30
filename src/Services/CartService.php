<?php
declare(strict_types=1);

namespace Vvintage\Services;

use Vvintage\Repositories\CartRepository;
use Vvintage\Models\User\User;
use Vvintage\Models\Cart\Cart;

final class CartService 
{
  private CartRepository  $cartRepository;

  // Создает экземпляр 
  public function __construct ( CartRepository $cartRepository)
  {
    $this->cartRepository = $cartRepository;
  }

  public function loadCartProducts()
  {
     
  }

  public function addItem (User $user, int $productId, bool $isLoggedIn): void
  {
    if ($isLoggedIn) 
    {
      $cart = $this->cartRepository->getCart($user);
      $products = $cart->getProducts();
      $this->cartRepository->saveCart($user, $cart);

      // Добавляем товар или увеличиваем количество
      if (!isset($products[$productId])) {
        $products[$productId] = 1;
      }

      $cart = new Cart($products);
      $this->cartRepository->saveCart($user, $cart);

      // Обноваляем пользователя в БД
      R::store($user);

      // Обновляем состояние корзины в сессии. Сохраняем сообщение о добавлении товара
      $_SESSION['cart'] = $cart;
      $_SESSION['success'][] = ['title' => 'Товар добавлен в корзину.'];

    }
     
    // Пользователь НЕ вошел в профиль
    // 1. Проверить наличие корзины пользователя
    // 2. Если корзина есть - работаем с ней, если нет - создаем новую
    if ( !$isLoggedIn) {
      // Получаем корзину из COOKIE
      $cart = json_decode($_COOKIE['cart'] ?? '[]', true);
    
      // 3. Добавляем товар в корзину, если его там нет
      if(!isset($cart[$productId] )) {
        // Формируем корзину в ассоциативный массив
        $cart[$productId] = 1;

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

        header('Location: ' . HOST . 'shop/' . $productId);
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


  //Слияние корзины (очистка куки, сохранение новой корзины в БД и сессию)
  public function mergeCartAfterLogin (User $user): void
  {
    // 1. Получаем корзину пользователя из БД (или создаём пустую)
    $userCart = $user->getCart() && method_exists($user->getCart(), 'toArray') 
                ? $user->getCart()->toArray()
                : [];
    dd($cartRepository->getCart($user));
    // 2. Получаем избранное пользвоателя
    $userFavList = !empty($user->fav_list) 
                   ? json_decode($user->fav_list, true) ?? [] 
                   : [];

    $merged = [
      'cart' => $userCart,
      'fav_list' => $userFavList
    ];


    // Объединение содержимое куки в цикле
    foreach(['cart', 'fav_list'] as $key) {
      if ( isset($_COOKIE[$key]) && !empty($_COOKIE[$key]) ) {
        $cookieData = json_decode($_COOKIE[$key], true) ?? [];

        foreach ( $cookieData as $itemKey => $value) {
          if ( isset($temp[$key][$itemKey]) ) {
            $merged[$key][$itemKey] += $value;
          } else {
            $merged[$key][$itemKey] = $value;
          }
        }
        // Очищаем cookies
        setcookie($key, '', time() - 3600, '/');
      }
    }

    // Сохраняем в БД
    if ($user->getCart()) {
      $cart = $user->getCart()->getProducts();
      $cart = json_encode($merged['cart']);
      dd($cart);
    } else {
      // Если корозины нет, создаем новую
      $cart = R::dispense('cart');
      $cart->items = json_encode($merged['cart']);
      $cart->user = $user;
      R::store($cart);
    }
// dd($user->getFavList());
    // $user->getFavList() = json_encode($merged['fav_list']);

    // Обновляем пользователя в БД
    R::store($user);

    // Обновляем сессию
    $_SESSION['cart'] = $merged['cart'];
    $_SESSION['fav_list'] = $merged['fav_list'];

    if (isset($_SESSION['logged_user']['name']) && trim($_SESSION['logged_user']['name']) !== '') {
      $_SESSION['success'][] = ['title' => 'Здравствуйте, ' . htmlspecialchars($_SESSION['logged_user']['name']), 'desc' => 'Вы успешно вошли на сайт. Рады снова видеть вас'];
    } else {
      $_SESSION['success'][] = ['title' => 'Здравствуйте!', 'desc' => 'Вы успешно вошли на сайт. Рады снова видеть вас'];
    }

    // 7. Переход на профиль
    header('Location: ' . HOST . 'profile');
    exit();
  } 

}