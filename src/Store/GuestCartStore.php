<?php
declare(strict_types=1);

namespace Vvintage\Store;

class GuestCartStore {
  public function load(): array {
    return isset($_COOKIE['cart'])
      ? json_decode($_COOKIE['cart'], true)
      : [];
  }

  public function save(array $cart): void {
    setcookie('cart', json_encode($cart), time() + 3600);
  }
}
