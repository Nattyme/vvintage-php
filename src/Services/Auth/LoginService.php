<?php
declare(strict_types=1);

namespace Vvintage\Services\Auth;


use Vvintage\Models\User\UserInterface;
use Vvintage\Models\User\GuestUser;
use Vvintage\Models\Shared\AbstractUserItemList;
use Vvintage\Services\Shared\AbstractUserItemListService;


final class AuthService
{
    public function getCartTotalPrice($products, $cartModel)
    {
      return !empty($products) ? $cartModel->getTotalPrice($products) : 0;
    }
  

}
