<?php
declare(strict_types=1);

namespace Vvintage\Store;

use Vvintage\Repositories\UserRepository;
use Vvintage\Models\User\UserInterface;
use Vvintage\Models\Cart\Cart;
use Vvintage\Auth\Auth;

class UserCartStore implements CartStoreInterface
{
  private UserRepository $userRepository;

  public function __construct(UserRepository $userRepository)
  {
    $this->userRepository = $userRepository;
  }

  public function load(): array
  {
    $user = $this->userRepository->findUserById((int) $_SESSION['user_id']);
    return $user->getCart() ?? [];
  }

  public function save (Cart $cartModel, ?UserInterface $userModel = null): void {

    $cart = $cartModel->getItems();
    // Записываем в БД
    $this->userRepository->saveUserCart($userModel, $cart);
  }

} 