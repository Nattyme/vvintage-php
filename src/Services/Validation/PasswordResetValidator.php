<?php
declare(strict_types=1);

namespace Vvintage\Services\Validation;

use Vvintage\Services\Security\PasswordResetService;
use Vvintage\Services\Messages\FlashMessage;

final class PasswordResetValidator
{
  private PasswordResetService $resetPassService;
  private FlashMessage $notes;

  public function __construct(PasswordResetService $resetPassService, FlashMessage $notes)
  {
    $this->resetPassService = $resetPassService;
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
    if ($email === '') {
      $this->notes->pushError('Введите email');
      $valid = false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $this->notes->pushError('Некорректный формат email');
      $valid = false;
    }

    return $valid;
  }
}

