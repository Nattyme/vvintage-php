<?php
declare(strict_types=1);

namespace Vvintage\Services\Validation;

use Vvintage\Repositories\User\UserRepository;
use Vvintage\Services\Base\BaseService;

final class LoginValidator extends BaseService
{
  private UserRepository $userData;

  public function __construct(UserRepository $userData)
  {
    parent::__construct(); // Важно!
    $this->userData = $userData;
  }

  public function validate(array $data): bool
  {
    $valid = true;
    $csrfToken = $data['csrf'] ?? '';
    
    if (!check_csrf($csrfToken)) {
      $this->flash->pushError('Неверный токен безопасности');
      $valid = false;
    } 

    $email = trim( strtolower($data['email']) ?? '');
    if ($email === '') {
      $this->flash->pushError('Введите email');
      $valid = false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $this->flash->pushError('Некорректный формат email');
      $valid = false;
    } elseif ($email) {
      $isUserInBlock = $this->userData->findBlockedUserByEmail($email);

      if ($isUserInBlock) {
        $this->flash->pushError('Ошибка, невозможно зайти в профиль.');
        $valid = false;
      }

    }

    $password = trim($data['password'] ?? '');
    if ($password === '') {
      $this->flash->pushError('Введите пароль');
      $valid = false;
    }


    return $valid;
  }
}

