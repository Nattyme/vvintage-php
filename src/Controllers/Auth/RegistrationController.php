<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Auth;

use Vvintage\Services\Security\RegistrationService;

final class RegistrationController 
{
  public static function index ($routeData) {
    // Если форма отправлена - делаем регистрацию
    if ( isset($_POST['register']) ) {
      // Проверка токена
      if (!check_csrf($_POST['csrf'] ?? '')) {
        $_SESSION['errors'][] = ['error', 'Неверный токен безопасности'];
      }

      // Проверка на заполненность
      if( trim($_POST['email']) == "" ) {
        // Ошибка - email пуст. Добавляем массив этой ошибки в массив $errors 
        $_SESSION['errors'][] = ['title' => 'Введите email', 'desc' => '<p>Email обязателен для регистрации на сайте</p>'];
      } else if ( !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ) {
        $_SESSION['errors'][] = ['title' => 'Введите корректный Email'];
      } else if ( trim($_POST['email']) ) {
        $regService = new RegistrationService ();
        $emailIsBlocked  = $regService->isEmailBlocked( trim($_POST['email']) );
        
        if ($emailIsBlocked) {
          $_SESSION['errors'][] = ['title' => 'Ошибка регистрации.'];
        }
      }

      if( trim($_POST['password']) == "") {
        // Ошибка - пароль пуст. Добавляем массив этой ошибки в массив $errors 
        $_SESSION['errors'][] = ['title' => 'Введите пароль', 'desc' => 'Пароль обязателен для регистрации на сайте'];
      }

      if( ! trim($_POST['password']) == "" && strlen(trim($_POST['password']) ) < 5) {
        $_SESSION['errors'][] = ['title' => 'Неверный формат пароля', 'desc' => '<p>Пароль должен быть больше четырёх символов</p>'];
      }

      // Проверка на занятый email
      $freeEmail = $regService->isEmailFree( trim($_POST['email']) );
      if ( !$freeEmail ) {
        $_SESSION['errors'][] = [
          'title' => 'Пользователь с таким email уже существует', 
          'desc' => '<p>Используйте другой email адрес или воспользуйтесь <a href="'.HOST.'lost-password">восстановлением пароля.</a></p>'
        ];
      }

      //Если нет ошибок - Регистрируем пользователя
      if ( empty($_SESSION['errors']) ) {
        RegistrationService::createNewUser($_POST);
      } else {
        $_SESSION['errors'][] = ['title' => 'Что-то пошло не так. Повторите действие заново.'];
      }
    }
      
      // Показываем форму
      self::renderForm($routeData);
  }

  private static function renderForm ($routeData) {
    $pageTitle = "Регистрация";
    $pageClass = "authorization-page";
 
    //Сохраняем код ниже в буфер
    ob_start();
    include ROOT . 'templates/login/form-registration.tpl';
    //Записываем вывод из буфера в пепеменную
    $content = ob_get_contents();
    //Окончание буфера, очищаем вывод
    ob_end_clean();

    include ROOT . "views/_page-parts/_head.tpl";
    include ROOT . "templates/login/login-page.tpl";
    include ROOT . "templates/_page-parts/_foot.tpl";

  }
}