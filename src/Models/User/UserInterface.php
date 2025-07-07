<?php
declare(strict_types=1);

namespace Vvintage\Models\User;

use Vvintage\Models\Cart\Cart;

interface UserInterface 
{
  // public function getRepository(): UserRepository;
  public function getId(): ?int;
  public function getCart(): array;
  public function setCart(array $cart): void;
  public function getCartModel(): Cart;
}