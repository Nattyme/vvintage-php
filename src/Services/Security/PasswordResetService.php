<?php
declare(strict_types=1);

namespace Vvintage\Services\Security;

use RedBeanPHP\R;

final class PasswordResetService 
{
  // Генерируем случайную строку заданной длины 
  private function randomStr(int $length = 30): string 
  {
    return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length);
  }

  // Метод проверяет, существует ли пользователь с таким email
  public function userExists(string $email): bool
  {
    $user = R::findOne('users', 'email = ?', [$email]);
    return $user !== null;
  }

  // Создает и сохраняет код восстановления для пользователя
  public function createRecoveryCode(string $email): ?string
  {
    $user = R::findOne('users', 'email = ?', [$email]);

    if (!$user) {
      return null;
    }

    // $code = $this->randomStr();
    $code = self::randomStr();

    // 5. Запомнить секретный код. Записать в БД.
    $user->recovery_code = $recovery_code;
    R::store($user);

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
                "From: =?utf-8?B?" . base64_encode(SITE_NAME) . "?= <" . SITE_EMAIL . ">" . PHP_EOL .
                "Reply-To: " . SITE_EMAIL . PHP_EOL;

    return mail($email, 'Восстановление доступа', $message, $headers);
  }

  // Главный метод, объединяющий все шаги
    public function processPasswordResetRequest(string $email): array
    {
        $errors = [];

        if (trim($email) === '') {
            $errors[] = ['title' => 'Введите email', 'desc' => '<p>Email - обязательное поле</p>'];
        } elseif (!filter_var(trim($email), FILTER_VALIDATE_EMAIL)) {
            $errors[] = ['title' => 'Введите корректный Email'];
        } elseif (!$this->userExists($email)) {
            $errors[] = ['title' => 'Пользователя с таким email не существует'];
        }

        if ($errors) {
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
