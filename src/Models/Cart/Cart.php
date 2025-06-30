<?php
declare(strict_types=1);

namespace Vvintage\Models\Cart;

final class Cart
{
  // Общая стоимость товаров в корзине
  private array $cart = [];

  public function __construct(array $cart = [])
  {
    $this->cart = $cart;
  }


  public function toArray() {
    return $this->cart;
  }

  // Метод получает корзину из БД или куки и записывает её в $this->cart
  /** 
   * @return array
   */
  public function getCart (bool $isLoggedIn, $user): array
  {
    if ( $isLoggedIn ) 
    {
      $cart = $user->getCart()->getProducts();
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
    return $this->cart[$productId] ?? 0; // если товара нет, возвращаем 0
  }

  public function getProducts (): array {
    return $this->cart;
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

  public function getTotalPrice (array $products): int
  {

    $total = 0;
    foreach ( $this->cart as $id => $quantity) {
      if(isset($products[$id])) {
        $total = $total + $products[$id]['price'] * $quantity;
      }
    }

    return $total;
  }

}