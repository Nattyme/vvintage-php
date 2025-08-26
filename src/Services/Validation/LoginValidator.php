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
      $this->notes->renderError('Неверный токен безопасности');
      $valid = false;
    } 

    $email = trim( strtolower($data['email']) ?? '');
    if ($email === '') {
      $this->notes->renderError('Введите email');
      $valid = false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $this->notes->renderError('Некорректный формат email');
      $valid = false;
    } elseif ($email) {
      $isUserInBlock = $this->userData->findBlockedUserByEmail($email);

      if ($isUserInBlock) {
        $this->notes->renderError('Ошибка, невозможно зайти в профиль.');
        $valid = false;
      }

    }

    $password = trim($data['password'] ?? '');
    if ($password === '') {
      $this->notes->renderError('Введите пароль');
      $valid = false;
    }


    return $valid;
  }
}

