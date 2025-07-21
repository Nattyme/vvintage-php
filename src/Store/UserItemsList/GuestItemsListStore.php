<?php
declare(strict_types=1);

namespace Vvintage\Store\UserItemsList;

use Vvintage\Models\User\UserInterface;
use Vvintage\Store\UserItemsList\ItemsListStoreInterface;
use Vvintage\Models\Cart\Cart;
use Vvintage\Models\Favorites\Favorites;

class GuestItemsListStore implements ItemsListStoreInterface {
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
