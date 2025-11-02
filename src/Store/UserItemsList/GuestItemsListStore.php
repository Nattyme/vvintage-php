<?php
declare(strict_types=1);

namespace Vvintage\Store\UserItemsList;

/** Контракты */
use Vvintage\Contracts\User\UserInterface;
use Vvintage\Contracts\User\UserItemsListStoreInterface;

/** Модели */
use Vvintage\Models\Cart\Cart;
use Vvintage\Models\Favorites\Favorites;

/** Сервисы */
use Vvintage\Services\Session\SessionService;

class GuestItemsListStore implements UserItemsListStoreInterface {
  private SessionService $sessionService;

  public function __construct() {
    $this->sessionService = new SessionService();
  }

  public function load($itemKey): array {
    
    return isset($_COOKIE[$itemKey]) && is_string($_COOKIE[$itemKey])
      ? json_decode($_COOKIE[$itemKey], true)
      : [];
  }

  public function save($itemKey, $itemModel, ?UserInterface $userModel = null): void 
  {
    
    $items = $itemModel->getItems(); // получаем массив корзины
    setcookie($itemKey, json_encode( $items), time() + 3600 * 24 * 7, '/');
  }
}
