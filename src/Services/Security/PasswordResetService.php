<?php
declare(strict_types=1);

namespace Vvintage\Services\Security;
use Vvintage\Repositories\User\UserRepository;

use RedBeanPHP\R;
use Vvintage\Config\Config;
use Vvintage\Services\Messages\FlashMessage;

final class PasswordResetService 
{
  private UserRepository $userRepository;
  private FlashMessage $notes;

  public function __construct (UserRepository $userRepository, FlashMessage $notes) {
    $this->userRepository = $userRepository;
    $this->notes = $notes;
  }

  // Генерируем случайную строку заданной длины 
  private function randomStr(int $length = 30): string 
  {
    return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length);
  }

  // Метод проверяет, существует ли пользователь с таким email
  public function userExists(string $email): bool
  {
    $user = $this->userRepository->findUserByEmail($email);

    return $user !== null;
  }

  // Создает и сохраняет код восстановления для пользователя
  public function createRecoveryCode(string $email): ?string
  {
    $user = $this->userRepository->findUserByEmail($email);

    if (!$user) {
      return null;
    }

    // $code = $this->randomStr();
    $code = $this->randomStr();

    // обновляем код в БД 
    $setNewPassService = new PasswordSetNewService( new UserRepository());
    $setNewPassService->updateRecoveryCodeByEmail($email, $code);

    return $code;
  }

  public function sendRecoveryEmail (string $email, string $recoveryCode): bool
  {
    $recoveryLink = HOST . "set-new-password?email=" . urlencode($email) . "&code=" . urlencode($recoveryCode);

    $message = "<p>Код сброса пароля: <strong>$recoveryCode</strong></p>";
    $message .= "<p>Для сброса пароля перейдите по ссылке ниже и установите новый пароль:</p>";
    $message .= '<p><a href="' . $recoveryLink . '">Установить новый пароль</a></p>';

    $headers =  "MIME-Version: 1.0" . PHP_EOL .
                "Content-Type: text/html; charset=utf-8" . PHP_EOL .
                "From: =?utf-8?B?" . base64_encode(Config::SITE_NAME) . "?= <" . Config::SITE_EMAIL . ">" . PHP_EOL .
                "Reply-To: " . Config::SITE_EMAIL . PHP_EOL;

    return mail($email, 'Восстановление доступа', $message, $headers);
  }

  // Главный метод, объединяющий все шаги
  public function processPasswordResetRequest(string $email): array
  {
      if (trim($email) === '') {
        $this->notes->pushError('Введите email', 'Email - обязательное поле');
      } elseif (!filter_var(trim($email), FILTER_VALIDATE_EMAIL)) {
        $this->notes->pushError('Введите корректный Email');
      } elseif (!$this->userExists($email)) {
        $this->notes->pushError('Пользователя с таким email не существует');
      }

      if ($$_SESSION['errors']) {
          return ['success' => false, 'errors' => $errors];
      }

      $code = $this->createRecoveryCode($email);

      if (!$code) {
          return ['success' => false, 'errors' => [['title' => 'Ошибка генерации кода восстановления']]];
      }

      $mailResult = $this->sendRecoveryEmail($email, $code);

      if (!$mailResult) {
          return ['success' => false, 'errors' => [['title' => 'Ошибка отправки письма']]];
      }

      return ['success' => true];
  }

}
