<?php
declare(strict_types=1);

namespace Vvintage\Services\Validation;


final class LoginValidator 
{
  public function validate(array $data): bool
  {
  
    $csrfToken = $data['csrf'] ?? '';
    if (!check_csrf($csrfToken)) throw new \Exception('Неверный токен безопасности');
    
    $email = trim( strtolower($data['email']) ?? '');
    if ($email === '') {
      throw new \Exception('Введите email');
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      throw new \Exception('Некорректный формат email');
    }

    $password = trim($data['password'] ?? '');
    if ($password === '')  throw new \Exception('Введите пароль');

  }
}

