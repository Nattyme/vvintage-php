<?php
declare(strict_types=1);

namespace Vvintage\Store;

use Vvintage\Repositories\UserRepository;
use Vvintage\Auth\Auth;

class UserCartStore 
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

  public function save(array $cart): void {
    $userModel = Auth::getLoggedInUser();
    $userModel->setCartModel($cart);

    // Записываем в БД
    $this->userRepository->save($user);
  }

} 