<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Security;

use Vvintage\Services\Security\PasswordResetService;

final class PasswordResetController {
  public static function index ($routeData) 
  {
    if (isset($_POST['lost-password'])) {
        if (!check_csrf($_POST['csrf'] ?? '')) {
            $_SESSION['errors'][] = ['error', 'Неверный токен безопасности'];
        } else {
            $passwordResetService = new PasswordResetService();
            $result = $passwordResetService->processPasswordResetRequest($_POST['email']);

            if ($result['success']) {
                $_SESSION['success'][] = [
                    'title' => 'Проверьте почту', 
                    'desc' => '<p>На указанную почту был отправлен email с ссылкой для сброса пароля.</p>'
                ];
            } else {
                foreach ($result['errors'] as $error) {
                    $_SESSION['errors'][] = $error;
                }
            }
        }
    }

    // Показываем форму
    self::renderForm($routeData);
  }

  private static function renderForm ($routeData) {
    $pageTitle = "Восстановить пароль";
    $pageClass = "authorization-page";
 
    //Сохраняем код ниже в буфер
    ob_start();
    include ROOT . 'views/login/lost-password.tpl';
    //Записываем вывод из буфера в пепеменную
    $content = ob_get_contents();
    //Окончание буфера, очищаем вывод
    ob_end_clean();


    include ROOT . "views/_page-parts/_head.tpl";
    include ROOT . "views/login/login-page.tpl";
    include ROOT . "views/_page-parts/_foot.tpl";

  }
}

