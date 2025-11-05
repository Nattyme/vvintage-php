<?php
declare(strict_types=1);

namespace Vvintage\Store\Cart;

use Vvintage\Models\Cart\Cart;
use Vvintage\Models\User\UserInterface;
use Vvintage\Public\Services\Cookie\CookieService;

class GuestCartStore implements CartStoreInterface {

  private CookieService $cookieService;

  public function __construct() {
    $this->cookieService = new CookieService();
  }

  public function load(): array {
    return $this->cookieService->getCookieValueByKey('cart');
  }

  public function save(Cart $cartModel, ?UserInterface $userModel = null): void 
  {
    $cart = $cartModel->getItems(); // получаем массив корзины
    $this->cookieService->setCookieValueByKey('cart', $cart); // сохраняем в куки
  }
}
