<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Auth;

use RedBeanPHP\R; // Подключаем readbean
use Vvintage\Routing\Router;
use Vvintage\Routing\RouteData;
use Vvintage\Models\Auth\Auth;
use Vvintage\Models\User\User;
use Vvintage\Repositories\UserRepository;
use Vvintage\Controllers\Cart\CartController;

require_once ROOT . './libs/functions.php';

final class AuthController 
{
    public static function login (RouteData $data): void {

      //1. Проверяем массив POST
      if( isset($_POST['login']) ) {
        // Проверка токена
        if (!check_csrf($_POST['csrf'] ?? '')) {
          $_SESSION['errors'][] = ['error', 'Неверный токен безопасности'];
        }

        //2. Заполненность полей. Проверка на заполненность
        if( trim($_POST['email']) == '' ) {
          // Ошибка - email пуст. Добавляем массив этой ошибки в массив $errors 
          $_SESSION['errors'][] = ['title' => 'Введите email', 'desc' => '<p>Email обязателен для регистрации на сайте</p>'];
        } else if ( !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ) {
          $_SESSION['errors'][] = ['title' => 'Введите корректный Email'];
        } else if ( trim(strtolower($_POST['email'])) ) {
          $blockedUsers  = R::findOne( 'blockedusers', ' email = ? ', [ $_POST['email'] ] );
          $result = $blockedUsers !== NULL ? true : false;
          
          if ($result) {
            $_SESSION['errors'][] = ['title' => 'Ошибка, невозможно зайти в профиль.'];
          }
        }

        if( trim($_POST['password']) == "") {
          // Ошибка - пароль пуст. Добавляем массив этой ошибки в массив $errors 
          $_SESSION['errors'][] = ['title' => 'Введите пароль'];
        }

        // Если ошибок нет
        if( empty($_SESSION['errors']) ) {

          // Ищем нужного пользователя в базе данных
          $userData = new UserRepository; // создаем новый объект репозитория
          $userBean =  $userData->findByEmail($_POST['email']);

          // Если в БД не найден email
          if (!$userBean) {
            $_SESSION['errors'][] = ['title' => 'Неверный email'];
          }

        
          if ( empty($_SESSION['errors']) ) {
            // Создаем нового пользователя
            $user = new User( $userBean);

            // Проверить пароль
            if ( password_verify($_POST['password'], $user->getPassword() ) ) {
              $loggedUser = Auth::login($user);
              $cartController = new CartController();
              $cartController->loadCart($loggedUser);
            
            } else {
              // Пароль не верен
              $_SESSION['errors'][] = ['title' => 'Неверный пароль'];
            }
          } 
        }
      }



      $pageTitle = "Вход на сайт";
      $pageClass = "authorization-page";

      //Сохраняем код ниже в буфер
      ob_start();
      include ROOT . 'views/login/form-login.tpl';
      //Записываем вывод из буфера в пепеменную
      $content = ob_get_contents();
      //Окончание буфера, очищаем вывод
      ob_end_clean();

      include ROOT . "views/_page-parts/_head.tpl";
      include ROOT . "views/login/login-page.tpl";
      include ROOT . "views/_page-parts/_foot.tpl";
    }

    public static function logout () {

    }

    public static function register () {

    }

    public static function setNewPassword () {

    }
}