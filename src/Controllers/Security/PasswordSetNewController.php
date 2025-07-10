<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Security;

use Vvintage\Services\Security\PasswordSetNewService;
use Vvintage\Services\Validation\PasswordSetNewValidator;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Repositories\UserRepository;

final class PasswordSetNewController {
  public static function index($routeData)
  {
      $userRepository = new UserRepository();
      $setNewPassService = new PasswordSetNewService($userRepository);
      $notes = new FlashMessage();

      $email = '';
      $resetCode = '';
      $newPasswordReady = false;

      // 1. Обработка отправки формы (POST)
      if (!empty($_POST['set-new-password'])) {
          $email = $_POST['email'] ?? '';
          $resetCode = $_POST['resetCode'] ?? '';
          $password = $_POST['password'] ?? '';

          $userModel = $setNewPassService->findUserByEmail($email);

          if ($userModel) {
              if ($userRepository->isValidRecoveryCode($email, $resetCode)) {

                $userRepository->updateUserPassword($password, $email);
                  $notes->pushSuccess('Пароль был успешно изменён');
                  $newPasswordReady = true;
              } else {
                  $notes->pushError('Неверный код восстановления');
              }
          } else {
              $notes->pushError('Пользователь не найден');
          }
      }

      // 2. Переход по ссылке из письма (GET)
      else if (!empty($_GET['email']) && !empty($_GET['code'])) {
          $email = $_GET['email'];
          $resetCode = $_GET['code'];

          $userModel = $setNewPassService->findUserByEmail($email);

          if (!$userModel) {
              $notes->pushError('Пользователь не найден');
              header("Location: " . HOST . "lost-password");
              exit;
          }

          if (!$userRepository->isValidRecoveryCode($email, $resetCode)) {
              $notes->pushError('Неверный или просроченный код восстановления');
              header("Location: " . HOST . "lost-password");
              exit;
          }

          // иначе — показываем форму смены пароля
      }

      // 3. Иначе — редирект на форму восстановления
      else {
          header("Location: " . HOST . "lost-password");
          exit;
      }

      // Отображение формы
      self::renderForm($routeData ?? [], $newPasswordReady, $email, $resetCode);
  }


  private static function renderForm($routeData, bool $newPasswordReady = false)
  {
    $pageTitle = "Установить новый пароль";
    $pageClass = "authorization-page";

    ob_start();
    include ROOT . 'views/login/set-new-password.tpl';
    $content = ob_get_contents();
    ob_end_clean();

    include ROOT . "views/_page-parts/_head.tpl";
    include ROOT . "views/login/login-page.tpl";
    include ROOT . "views/_page-parts/_foot.tpl";
  }

}

