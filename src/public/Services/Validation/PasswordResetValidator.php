<?php
declare(strict_types=1);

namespace Vvintage\Services\Validation;

final class PasswordResetValidator 
{

  public function validate(array $data): void
  {

    $csrfToken = $data['csrf'] ?? '';
    if (!check_csrf($csrfToken)) throw new \Exception('Неверный токен безопасности');
      

    $email = trim($data['email'] ?? '');
    if ($email === '') {
      throw new \Exception('Введите email');
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      throw new \Exception('Некорректный формат email');
    } 
  }
}

