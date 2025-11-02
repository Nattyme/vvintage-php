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
use Vvintage\Services\Cookie\CookieService;

class GuestItemsListStore implements UserItemsListStoreInterface {
  private SessionService $sessionService;
  private CookieService $cookieService;

  public function __construct() {
    $this->sessionService = new SessionService();
    $this->cookieService = new CookieService();
  }

  /**
   * Получает и декодирует корзину из cookie. Если нет - возвращает пустой массив
   *
   * @param string $itemKey
   * @return array
 */
  public function load($itemKey): array {
    return $this->cookieService->getCookieValueByKey($itemKey);
  }

  public function save($itemKey, $itemModel, ?UserInterface $userModel = null): void 
  {
    $items = $itemModel->getItems(); // получаем массив корзины
    $this->cookieService->setCookieValueByKey($itemKey, $items); // сохраняем в куки на 7 дней, доступ к куки по всему сайту
  }
}
