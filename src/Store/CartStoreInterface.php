<?php
declare(strict_types=1);

namespace Vvintage\Store;

use Vvintage\Models\User\UserInterface;
use Vvintage\Models\Cart\Cart;

interface CartStoreInterface 
{
  public function save(Cart $cartModel, ?UserInterface $userModel = null): void;

}