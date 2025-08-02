<?php
declare(strict_types=1);

namespace Vvintage\Contracts\Cart;

use Vvintage\Models\Cart\Cart;

interface CartRepositoryInterface
{    
  
    public function getCart(User $user): Cart;

    public function saveCart(User $user, Cart $cart): void;
}
