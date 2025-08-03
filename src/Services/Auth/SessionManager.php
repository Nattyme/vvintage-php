<?php

declare(strict_types=1);

namespace Vvintage\Services\Auth;

use RedBeanPHP\R; // Подключаем readbean
use Vvintage\Models\User\User;
use Vvintage\Models\User\GuestUser;
use Vvintage\Models\User\UserInterface;
use Vvintage\Repositories\User\UserRepository;
use Vvintage\Store\Cart\GuestCartStore;
use Vvintage\Store\Favorites\GuestFavoritesStore;

class SessionManager
{
    public static function setUserSession(User $user): bool
    {
        // Автологин пользователя после регистрации
        $_SESSION['logged_user'] = $user->export($user);
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['login'] = 1;
        $_SESSION['role'] = $user->getRole();
     
        $_SESSION['cart'] =  $user->getCart();
        $_SESSION['fav_list'] = $user->getFavList();

        if ($_SESSION['login']) {
            return true;
        }

        return false;
    }

    public static function isLoggedIn(): bool
    {
        $result = false;

        if (isset($_SESSION['logged_user']) && $_SESSION['user_id'] && $_SESSION['login'] === 1) {
            $result = true;
        }
        return $result;
    }

    public static function logout(): void
    {
      if (empty($_SESSION['errors'])) {
        session_destroy();
        setcookie(session_name(), '', time() - 60);
        header("Location: " . HOST);
      }
    }


    public static function getLoggedInUser(): ?UserInterface
    {
        // Если не пользователь - возвращаем экземпляр гостя с корзиной из куки
        if (!isset($_SESSION['user_id'])) {
          $guestCart = ( new GuestCartStore() )->load();
          $guestFav = ( new GuestFavoritesStore() )->load();
          return new GuestUser( ['cart'=> $guestCart, 'fav' => $guestFav] );
        }

        $userRepository = new UserRepository();
        
        return $userRepository->findUserById((int) $_SESSION['user_id']);
    }

}
