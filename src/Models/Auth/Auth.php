<?php

declare(strict_types=1);

namespace Vvintage\Models\Auth;

use RedBeanPHP\R; // Подключаем readbean
use Vvintage\Models\User\User;
use Vvintage\Models\User\GuestUser;
use Vvintage\Models\User\UserInterface;
use Vvintage\Repositories\UserRepository;
use Vvintage\Store\GuestCartStore;
class Auth
{
    public static function setUserSession(User $user): bool
    {

        // Автологин пользователя после регистрации
        $_SESSION['logged_user'] = $user->export($user);
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['login'] = 1;
        $_SESSION['role'] = $user->getRole();
        $_SESSION['cart'] =  $_SESSION['logged_user']['cart'];
        $_SESSION['fav_list'] = $user->getFavList();


        if ($_SESSION['login']) {
            return true;
        }

        return false;
        // $cartObj = $user->getCart();
        // Слияние корзины (очистка куки, сохранение новой корзины в БД и сессию)
        // $cartNew = $cartObj->mergeCartAfterLogin(true, $user);

        // Обновляем избранное в сессии
        // $_SESSION['fav_list'] = $temp_fav_list;
        // if (isset($_SESSION['logged_user']['name']) && trim($_SESSION['logged_user']['name']) !== '') {
        //   $_SESSION['success'][] = ['title' => 'Здравствуйте, ' . htmlspecialchars($_SESSION['logged_user']['name']), 'desc' => 'Вы успешно вошли на сайт. Рады снова видеть вас'];
        // } else {
        //   $_SESSION['success'][] = ['title' => 'Здравствуйте!', 'desc' => 'Вы успешно вошли на сайт. Рады снова видеть вас'];
        // }

        // header('Location: ' . HOST . 'profile');
        // exit();

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
        unset(
            $_SESSION['logged_user'],
            $_SESSION['user_id'],
            $_SESSION['login'],
            $_SESSION['role'],
            $_SESSION['cart'],
            $_SESSION['fav_list']
        );
    }

    public static function getLoggedInUser(): ?UserInterface
    {
        // Если не пользователь - возвращаем экземпляр гостя с корзиной из куки
        if (!isset($_SESSION['user_id'])) {
          $guestCart = ( new GuestCartStore() )->load();
            return new GuestUser( $guestCart );
        }

        $userRepository = new UserRepository();
        
        return $userRepository->findUserById((int) $_SESSION['user_id']);
    }

}
