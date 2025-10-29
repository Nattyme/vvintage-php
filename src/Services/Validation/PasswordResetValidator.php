<?php
declare(strict_types=1);

namespace Vvintage\Services\Validation;

use Vvintage\Services\Security\PasswordResetService;
use Vvintage\Services\Base\BaseService;

final class PasswordResetValidator extends BaseService
{
  private PasswordResetService $service;

  public function __construct(PasswordResetService $service)
  {
    parent::__construct();
    $this->service = $service;
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
    if ($email === '') {
      $this->flash->pushError('Введите email', 'Email - обязательное поле');
      $valid = false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $this->flash->pushError('Некорректный формат email');
      $valid = false;
    } elseif (!$this->service->userExists($email)) {
      $this->flash->pushError('Пользователя с таким email не существует');
      $valid = false;
    }

    return $valid;
  }
}

