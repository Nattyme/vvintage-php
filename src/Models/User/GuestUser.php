<?php

class GuestUser implements UserInterface 
{
  private $cart;

   public function __construct()
    {
        $this->cart = new Cart(new GuestCartStore());
        // $this->fav_list = json_decode($bean->fav_list ?? '[]', true);
    }
  // public function getRepository(): UserRepository {
  //   return new UserRepository();
  // }

  public function getId(): ?int {
    return null;
  }
}