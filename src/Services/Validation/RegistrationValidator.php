<?php
declare(strict_types=1);

namespace Vvintage\Services\Validation;

use Vvintage\Services\Security\RegistrationService;
use Vvintage\Services\Base\BaseService;

final class RegistrationValidator extends BaseService
{
  private RegistrationService $regService;

  public function __construct(RegistrationService $regService)
  {
      parent::__construct(); // Важно!
    $this->regService = $regService;
  }

  public function validate(array $data): bool
  {
    $valid = true;

    $csrfToken = $data['csrf'] ?? '';
    if (!check_csrf($csrfToken)) {
      $this->flash->pushError('Неверный токен безопасности');
      $valid = false;
    }

    $email = trim($data['email'] ?? '');
    $password = trim($data['password'] ?? '');

    if ($email === '') {
      $this->flash->pushError('Введите email', 'Email обязателен для регистрации на сайте');
      $valid = false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $this->flash->pushError('Введите корректный Email');
      $valid = false;
    } elseif ($this->regService->isEmailBlocked($email)) {
      $this->flash->pushError('Ошибка регистрации.');
      $valid = false;
    }

    if ($password === '') {
      $this->flash->pushError('Введите пароль', 'Пароль обязателен для регистрации на сайте');
      $valid = false;
    } elseif (strlen($password) < 5) {
      $this->flash->pushError('Неверный формат пароля', 'Пароль должен быть больше четырёх символов');
      $valid = false;
    }

    if ($this->regService->isEmailFree($email)) {
      $this->flash->pushError(
        'Пользователь с таким email уже существует',
        'Используйте другой email адрес или воспользуйтесь <a href="' . HOST . 'lost-password">восстановлением пароля.</a>'
      );
      $valid = false;
    }

    return $valid;
  }
}
