<?php
declare(strict_types=1);

namespace Vvintage\Models\User;

/** Контракт */
use Vvintage\Contracts\User\UserInterface;

use Vvintage\Models\Cart\Cart;
use Vvintage\Models\Favorites\Favorites;



class GuestUser implements UserInterface  
{
  private array $cart;
  private array $fav;

  public function __construct($data)

  {
    $this->cart = $data['cart'] ?? [];
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

  public function set($itemKey, array $products): void
  {
    $this->$itemKey = $products;
  }

  public function setFav(array $fav): void
  {
    $this->fav = $fav;
  }

 
  public function getFavModel(): Favorites
  {
    return new Favorites ($this->fav);
  }

  public function getFavList(): array
  {
    return $this->fav;
  }

  public function getRole(): string
  {
    return 'guest';
  }



  

}