<?php
declare(strict_types=1);

namespace Vvintage\Services\Validation;

use Vvintage\Services\Security\RegistrationService;


final class RegistrationValidator 
{
  
  public function validate(array $data): void
  {
  
    $csrfToken = $data['csrf'] ?? '';
    if (!check_csrf($csrfToken)) throw new \Exception('Неверный токен безопасности');

    $email = trim($data['email'] ?? '');
    if ($email === '') {
      throw new \Exception('Введите email');
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      throw new \Exception('Недопустимый формат Email');
    } elseif ($this->userRepository->findBlockedUserByEmail($email)) {
      throw new \Exception('Ошибка регистрации');
    }

    $password = trim($data['password'] ?? '');
    if ($password === '') {
      throw new \Exception('Введите пароль');
    } elseif (strlen($password) < 5) {
      throw new \Exception('Пароль должен быть больше четырёх символов');
    }
  }
}
