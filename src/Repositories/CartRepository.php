<?php
declare(strict_types=1);

namespace Vvintage\Repositories;

use RedBeanPHP\R; // Подключаем readbean
use RedBeanPHP\OODBBean; // для обозначения типа даннных
use Vvintage\Models\Cart\Cart;

final class CartRepository 
{
  public function getCart (User $user): Cart
  {
    $cartData = json_decode($user->getCart() ?? '[]', true);
    return new Cart($cartData);
  }

  public function saveCart (User $user, Cart $cart): void
  {
    $user->cart = json_encode($cart->getProducts());
    R::store($user);
  }
}

