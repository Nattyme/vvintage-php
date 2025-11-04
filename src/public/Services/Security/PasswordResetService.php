<?php
declare(strict_types=1);

namespace Vvintage\public\Services\Security;

use Vvintage\Config\Config;
use Vvintage\public\Services\Base\BaseService;
use Vvintage\Repositories\User\UserRepository;

final class PasswordResetService extends BaseService
{
  private UserRepository $userRepository;

  public function __construct (UserRepository $userRepository) {
    parent::__construct(); // Важно!
    $this->userRepository = $userRepository;
  }

  // Генерируем случайную строку заданной длины 
  private function randomStr(int $length = 30): string 
  {
    return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length);
  }

  // Метод проверяет, существует ли пользователь с таким email
  public function userExists(string $email): bool
  {
    $user = $this->userRepository->getUserByEmail($email);

    return $user !== null;
  }

  // Создает и сохраняет код восстановления для пользователя
  public function createRecoveryCode(string $email): ?string
  {
    $user = $this->userRepository->getUserByEmail($email);

    if (!$user) throw new \Exception('Пользователь с таким email не найден');

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
  public function processPasswordResetRequest(string $email): void
  {
      $code = $this->createRecoveryCode( trim($email) );
      if (!$code) throw new \Exception ('Ошибка генерации кода восстановления');
     
      $mailResult = $this->sendRecoveryEmail($email, $code);

      if (!$mailResult) throw new \Exception ('Ошибка отправки письма с кодом восстановления');
  }

}
