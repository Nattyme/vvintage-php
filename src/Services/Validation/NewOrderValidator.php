<?php
declare(strict_types=1);

namespace Vvintage\Services\Validation;

use Vvintage\Services\Auth\SessionManager;
use Vvintage\Repositories\User\UserRepository;
use Vvintage\Services\Base\BaseService;

final class NewOrderValidator extends BaseService
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
      $this->flash->renderError('Неверный токен безопасности');
      $valid = false;
    } 

    $email = isset($data['email']) ? trim(strtolower($data['email'])) : '';

    if ($email === '') {
      $this->flash->pushError('Введите email');
      $valid = false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $this->flash->pushError('Некорректный формат email');
      $valid = false;
    } elseif ($email) {
      $isUserInBlock = $this->userData->findBlockedUserByEmail($email);

      if ($isUserInBlock) {
        $this->flash->pushError('Ошибка, невозможно оформить заказ для этого email.');
        $valid = false;
      }

    } elseif ( empty(trim($data['name'])) ) {
      $this->flash->pushError('Поле "Имя" пустое. Заполните данные для отправки.');
    } elseif ( empty(trim($data['phone'])) ) {
        $this->flash->pushError('Поле "Телефон" пустое. Заполните данные для отправки.');
    }  else if ( empty(trim($data['address'])) ) {
        $this->flash->pushError('Поле "Адрес" пустое. Заполните данные для отправки.');
    } 

    return $valid;
  }
}

