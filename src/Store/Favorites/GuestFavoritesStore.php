<?php
declare(strict_types=1);

namespace Vvintage\Store\Favorites;

use Vvintage\Models\User\UserInterface;
use Vvintage\Models\Favorites\Favorites;
use Vvintage\Public\Services\Cookie\CookieService;

class GuestFavoritesStore implements FavoritesStoreInterface {
  private CookieService $cookieService;

  public function __construct() {
    $this->cookieService = new CookieService();
  }

  public function load(): array 
  {
    return $this->cookieService->getCookieValueByKey('fav_list');
  }


  public function save(Favorites $favModel, ?UserInterface $userModel = null): void 
  {
    $fav = $favModel->getItems(); // получаем массив избранного
    $this->cookieService->setCookieValueByKey('fav_list', $fav); // сохраняем в куки
  }
}
