<?php
declare(strict_types=1);

namespace Vvintage\Store\Favorites;

use Vvintage\Repositories\UserRepository;
use Vvintage\Models\User\UserInterface;
use Vvintage\Models\Favorites\Favorites;
use Vvintage\Services\Session\SessionService;

class UserFavoritesStore implements FavoritesStoreInterface
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
    
    return $user->getFavList() ?? [];
  }

  public function save (Favorites $favModel, ?UserInterface $userModel = null): void 
  {
    $sessionService = new SessionService();
    $fav = $favModel->getItems();

    // Записываем в БД
    $this->userRepository->saveUserFav($userModel, $fav);

    // Обновляем объект User в сессии
    $userModel->setFav( $favModel->getItems() );

    //  Обновляем данные пользователя в сессии
    $sessionService->setUserSession($userModel);  // обновляем logged_user
}

} 