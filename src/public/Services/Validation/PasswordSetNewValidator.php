<?php
declare(strict_types=1);

namespace Vvintage\Public\Services\Validation;


final class PasswordSetNewValidator 
{

  public function validate(array $data): void
  {
 
    $csrfToken = $data['csrf'] ?? '';
    if (!check_csrf($csrfToken)) throw new \Exception('Неверный токен безопасности');

    $email = trim($data['email'] ?? '');
    $password = trim($data['password'] ?? '');

    if ($email === '') {
      throw new \Exception('Введите email');
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
       throw new \Exception('Введите корректный Email');
    } 

    if ($password === '') {
      throw new \Exception('Введите пароль');
    } elseif (strlen($password) < 5) {
       throw new \Exception('Пароль должен быть больше четырёх символов');
    }

  }
}
