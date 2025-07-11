<?php
declare(strict_types=1);

namespace Vvintage\Store\Favorites;

use Vvintage\Models\User\UserInterface;
use Vvintage\Models\Favorites\Favorites;

class GuestFavoritesStore implements FavoritesInterface {
  public function load(): array {
    
    return isset($_COOKIE['fav_list']) && is_string($_COOKIE['fav_list'])
      ? json_decode($_COOKIE['fav_list'], true)
      : [];
  }

  public function save(Favorites $favModel, ?UserInterface $userModel = null): void 
  {
    $fav = $favModel->getItems(); // получаем массив избранного
    setcookie('fav_list', json_encode($fav), time() + 3600 * 24 * 7, '/');
  }
}
