<?php
declare(strict_types=1);

namespace Vvintage\Models\Auth;


use RedBeanPHP\R; // Подключаем readbean
use Vvintage\Models\User\User;
use Vvintage\Repositories\UserRepository;


// findByEmail
class Auth 
{
  public static function login (User $user): bool 
  {

      // Автологин пользователя после регистрации
      // Преобразуем объект user в массив и сохрагняем в сессию
      $_SESSION['logged_user'] = $user->export($user);
      $_SESSION['user_id'] = $user->getId();
      $_SESSION['login'] = 1;
      $_SESSION['role'] = $user->getRole();
      $_SESSION['cart'] = $_SESSION['logged_user']['cart']->getItems();
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

    if ( isset($_SESSION['logged_user']) && $_SESSION['user_id'] && $_SESSION['login'] === 1 ) {
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

  public static function getLoggedInUser(): ?User
  {
  
    if (!isset($_SESSION['user_id'])) {
      return null;
    }

    $userRepo = new UserRepository();
    $userBean = $userRepo->findById($_SESSION['user_id']);

    return new User($userBean) ? new User($userBean) : null;
  }

}

