<?php

declare(strict_types=1);

namespace Vvintage\Services\Cookie;


/** Контракт */
// use Vvintage\Contracts\User\UserInterface;

// /** Модели */
// use Vvintage\Models\User\User;
// use Vvintage\Models\User\GuestUser;

// /** Репозитории */
// use Vvintage\Repositories\User\UserRepository;

// /** Хранилище */
// use Vvintage\Store\Cart\GuestCartStore;
// use Vvintage\Store\Favorites\GuestFavoritesStore;

class CookieService
{
 
    /**
     * Очищает куки сессии для указанного ключа
     * 
     * @param string $sessionKey ключ сессии, для которого нужно очистить куки
     */
    public function clear(string $sessionKey): void
    {
      if (!isset($_COOKIE[$sessionKey])) return;
      
      setcookie($sessionKey, '', time() - 3600, '/');
    }

}
