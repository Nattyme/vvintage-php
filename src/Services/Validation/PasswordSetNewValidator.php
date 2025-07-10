<?php
declare(strict_types=1);

namespace Vvintage\Services\Validation;

use Vvintage\Services\Security\PasswordSetNewService;
use Vvintage\Services\Messages\FlashMessage;

final class PasswordSetNewValidator
{
  private PasswordSetNewService $setNewPassService;
  private FlashMessage $notes;

  public function __construct(PasswordSetNewService $setNewPassService, FlashMessage $notes)
  {
    $this->setNewPassService = $setNewPassService;
    $this->notes = $notes;
  }

  public function validate(array $data): bool
  {
    $valid = true;

    $csrfToken = $data['csrf'] ?? '';
    if (!check_csrf($csrfToken)) {
      $this->notes->pushError('Неверный токен безопасности');
      $valid = false;
    }

    $email = trim($data['email'] ?? '');
    $password = trim($data['password'] ?? '');

    if ($email === '') {
      $this->notes->pushError('Введите email', 'Email обязателен для регистрации на сайте');
      $valid = false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $this->notes->pushError('Введите корректный Email');
      $valid = false;
    } elseif ($this->regService->isEmailBlocked($email)) {
      $this->notes->pushError('Ошибка регистрации.');
      $valid = false;
    }

    if ($password === '') {
      $this->notes->pushError('Введите пароль', 'Пароль обязателен для регистрации на сайте');
      $valid = false;
    } elseif (strlen($password) < 5) {
      $this->notes->pushError('Неверный формат пароля', 'Пароль должен быть больше четырёх символов');
      $valid = false;
    }

    if (! $this->regService->isEmailFree($email)) {
      $this->notes->pushError(
        'Пользователь с таким email уже существует',
        'Используйте другой email адрес или воспользуйтесь <a href="' . HOST . 'lost-password">восстановлением пароля.</a>'
      );
      $valid = false;
    }

    return $valid;
  }
}
