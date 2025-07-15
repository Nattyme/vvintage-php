<?php
declare(strict_types=1);

namespace Vvintage\Models\User;

use Vvintage\Models\Cart\Cart;
use Vvintage\Models\User\UserInterface;
use Vvintage\Models\Favorites\Favorites;

class GuestUser implements UserInterface  
{
  private array $cart;
  private array $fav;

  public function __construct($data)
  // public function __construct(array $cart, array $fav=[])
  {
    $this->cart = $data['cart'] ?? [];
    // $this->cart = $cart ?? [];
    // $this->fav = $fav ?? [];
    $this->fav = $data['fav'] ?? [];
  }

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

 
  public function getFavModel(): Favorites
  {
    return new Favorites ($this->fav);
  }

  public function getFavList(): array
  {
    return $this->fav;
  }


  

}