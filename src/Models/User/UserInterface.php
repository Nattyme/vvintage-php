<?php
declare(strict_types=1);

namespace Vvintage\Models\User;

interface UserInterface 
{
  // public function getRepository(): UserRepository;
  public function load(): array;
  public function getId(): ?int;
  public function getCart(): array;
  public function setCart(array $cart): void;
  public function getCartModel(): Cart;
}