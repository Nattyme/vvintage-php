<?php
declare(strict_types=1);

namespace Vvintage\Models\Auth;

use RedBeanPHP\R; // Подключаем readbean


// findByEmail
class Auth 
{
  public static function login ($user) {

      // Автологин пользователя после регистрации
      // Преобразуем объект user в массив и сохрагняем в сессию
      $_SESSION['logged_user'] = $user;
      $_SESSION['login'] = 1;
      $_SESSION['role'] = $user->getRole();
      $_SESSION['cart'] = $user->getCart();
      $_SESSION['fav_list'] = $user->getFavList();
  
      // Работа с корзиной
      // Действия:
      // 1. Достать корзину из БД
      // 2. Совместить ее с COOKIES, если они есть
      // 3. Сохранить полученную корзину в БД
      // 4. Сохранить полученную корзину в сессию
      // 5. Очистить корзину COOKIE
      // Cart::mergeCartAfterLogin(bool $isLoggedIn, $user);
    

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


}

