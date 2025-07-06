<?php
declare(strict_types=1);

namespace Vvintage\Models\User;

use Vvintage\Models\Cart\Cart;
use Vvintage\Models\User\UserInterface;
use Vvintage\Store\GuestCartStore;

class GuestUser implements UserInterface  
{
  private $cart;

  public function __construct(array $cart)
  {
    $this->cart = $cart;
        // $this->fav_list = json_decode($bean->fav_list ?? '[]', true);
  }
  public function load(): array
  {
    return [];
      // Для гостевого пользователя может быть пусто или логика по умолчанию
  }

  // public function getRepository(): UserRepository {
  //   return new UserRepository();
  // }

  public function getId(): ?int {
    return null;
  }

  public function getCart(): array
  {
    return $this->cart;
  }

  public function getCartModel(): Cart
  {
    return new Cart($this->cart);
  }

  public function setCart(array $cart): void
  {
    $this->cart = $cart;
  }

}