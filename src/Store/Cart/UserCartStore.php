<?php
declare(strict_types=1);

namespace Vvintage\Store\Cart;

use Vvintage\Repositories\UserRepository;
use Vvintage\Models\User\UserInterface;
use Vvintage\Models\Cart\Cart;
use Vvintage\Utils\Services\Session\SessionService;

class UserCartStore implements CartStoreInterface
{
  private UserRepository $userRepository;

  public function __construct(UserRepository $userRepository)
  {
    $this->userRepository = $userRepository;
  }

  public function load(): array
  {
    $userId = $this->sessionService->getLoggedInUserId();
    $user = $this->userRepository->findUserById( $userId );
    
    return $user->getCart() ?? [];
  }

  public function save (Cart $cartModel, ?UserInterface $userModel = null): void 
  {
    $sessionService = new SessionService();
    $cart = $cartModel->getItems();

    // Записываем в БД
    $this->userRepository->saveUserCart($userModel, $cart);

    // Обновляем объект User в сессии
    $userModel->setCart( $cartModel->getItems() );

    //  Обновляем данные пользователя в сессии
     $sessionService->setUserSession($userModel);  // обновляем logged_user
}

} 