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

    /**
     * Возвращает значение куки по указанному ключу
     * 
     * @param string $cookieKey ключ куки, для которого нужно получить значение
     * @return array значение куки по указанному ключу, если оно существует, иначе пустой массив
    */
    public function getCookieValueByKey(string $cookieKey): array
    {
      return isset($_COOKIE[$cookieKey]) && is_string($_COOKIE[$cookieKey])
              ? json_decode($_COOKIE[$cookieKey], true)
              : [];
    }

    public function setCookieValueByKey(string $cookieKey, array $value): void
    {
      setcookie($cookieKey, json_encode( $value ), time() + 3600 * 24 * 7, '/'); // сохраняем в куки на 7 дней, доступ к куки по всему сайту
    }

}
