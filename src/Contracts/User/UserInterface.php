<?php
declare(strict_types=1);

namespace Vvintage\Contracts\User;

use Vvintage\Models\Cart\Cart;
use Vvintage\Models\Favorites\Favorites;
use Vvintage\Models\User\User;

interface UserInterface 
{
  public function getRole(): string;
  public function getId(): ?int;
  public function getCart(): array;
  public function set($itemKey, array $items): void;
  public function getCartModel(): Cart;

  public function getFavList(): array;
  public function getFavModel(): Favorites;
}