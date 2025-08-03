<?php
declare(strict_types=1);

namespace Vvintage\Contracts\User;

use Vvintage\Models\Cart\Cart;
use Vvintage\Models\Favorites\Favorites;

interface UserInterface 
{
  public function getRole(): string;
  public function getId(): ?int;
  public function getCart(): array;
  public function set($itemKey, array $items): void;
  public function getCartModel(): Cart;

  public function getFavList(): array;
  // public function setFav(array $fav): void;
  public function getFavModel(): Favorites;
}