<?php
declare(strict_types=1);

namespace Vvintage\Repositories;

use RedBeanPHP\R; // Подключаем readbean
use RedBeanPHP\OODBBean; // для обозначения типа даннных
use Vvintage\Models\Cart\Cart;

final class CartRepository 
{
  public function getCart (User $user): array
  {
    $cart = json_decode($user->getCart() ?? '[]', true);

  }
}

