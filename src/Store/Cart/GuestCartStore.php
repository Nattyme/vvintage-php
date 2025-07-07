<?php
declare(strict_types=1);

namespace Vvintage\Store\Cart;

use Vvintage\Models\User\UserInterface;
use Vvintage\Models\Cart\Cart;

class GuestCartStore implements CartStoreInterface {
  public function load(): array {
    
    return isset($_COOKIE['cart']) && is_string($_COOKIE['cart'])
      ? json_decode($_COOKIE['cart'], true)
      : [];
  }

  public function save(Cart $cartModel, ?UserInterface $userModel = null): void 
  {
    $cart = $cartModel->getItems(); // получаем массив корзины
    setcookie('cart', json_encode($cart), time() + 3600 * 24 * 7, '/');
  }
}
