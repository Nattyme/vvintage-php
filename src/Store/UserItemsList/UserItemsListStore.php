<?php
declare(strict_types=1);

namespace Vvintage\Store\UserItemsList;

use Vvintage\Repositories\UserRepository;
use Vvintage\Store\UserItemsList\ItemsListStoreInterface;
use Vvintage\Models\User\UserInterface;
use Vvintage\Models\Cart\Cart;
use Vvintage\Services\Auth\SessionManager;

class UserItemsListStore implements ItemsListStoreInterface
{
  private UserRepository $userRepository;

  public function __construct(UserRepository $userRepository)
  {
    $this->userRepository = $userRepository;
  }

  public function load($itemKey): array
  {
    $user = $this->userRepository->findUserById((int) $_SESSION['user_id']);
    return $user->getCart() ?? [];
  }
// public function save($itemKey, $itemModel, ?UserInterface $userModel = null): void;
  public function save ($itemKey, $itemModel, ?UserInterface $userModel = null): void 
  {
    $items = $itemModel->getItems();

    // Записываем в БД
    $this->userRepository->saveUserItemsList($itemKey, $userModel, $items);

    // Обновляем объект User в сессии
    $userModel->set( $itemKey, $itemModel->getItems() );

    //  Обновляем данные пользователя в сессии
    SessionManager::setUserSession($userModel);  // обновляем logged_user
}

} 