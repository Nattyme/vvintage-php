<?php
declare(strict_types=1);

namespace Vvintage\Services\Cart;

use RedBeanPHP\R;
use Vvintage\Models\Cart\Cart;
use Vvintage\Models\User\User;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Shared\AbstractUserItemsListService;


final class CartService extends AbstractUserItemsListService
{
    public function getCartTotalPrice($products, $cartModel)
    {
      return !empty($products) ? $cartModel->getTotalPrice($products) : 0;
    }
  

}
