<?php
declare(strict_types=1);

namespace Vvintage\Store\Favorites;

use Vvintage\Repositories\UserRepository;
use Vvintage\Models\User\UserInterface;
use Vvintage\Models\Favorites\Favorites;
use Vvintage\Services\Auth\SessionManager;

class UserFavoritesStore implements FavoritesStoreInterface
{
  private UserRepository $userRepository;

  public function __construct(UserRepository $userRepository)
  {
    $this->userRepository = $userRepository;
  }

  public function load(): array
  {
    $user = $this->userRepository->findUserById((int) $_SESSION['user_id']);
    return $user->getFavList() ?? [];
  }

  public function save (Favorites $favModel, ?UserInterface $userModel = null): void 
  {
dd('сораняем');
    $fav = $favModel->getItems();

    // Записываем в БД
    $this->userRepository->saveUserFav($userModel, $fav);

    // Обновляем объект User в сессии
    $userModel->setFav( $favModel->getItems() );

    //  Обновляем данные пользователя в сессии
    SessionManager::setUserSession($userModel);  // обновляем logged_user
}

} 