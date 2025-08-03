<?php
declare(strict_types=1);

namespace Vvintage\Store\UserItemsList;


/** Контракты */
use Vvintage\Contracts\User\UserInterface;
use Vvintage\Contracts\User\UserItemsListStoreInterface;

/** Репозитории */
use Vvintage\Repositories\User\UserRepository;

/** Модели */
use Vvintage\Models\Cart\Cart;

/** Сервисы */
use Vvintage\Services\Auth\SessionManager;

class UserItemsListStore implements UserItemsListStoreInterface
{
  private UserRepository $userRepository;

  public function __construct(UserRepository $userRepository)
  {
    $this->userRepository = $userRepository;
  }

  public function load($itemKey): array
  {
    $userId = (int) $_SESSION['user_id'];

    return $this->userRepository->getItemsList($userId, $itemKey) ?? [];
  }

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