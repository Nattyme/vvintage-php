<?php
declare(strict_types=1);

namespace Vvintage\Services\Validation;

use Vvintage\Services\Auth\SessionManager;
use Vvintage\Repositories\UserRepository;
use Vvintage\Services\Messages\FlashMessage;

final class NewOrderValidator
{
  private UserRepository $userData;
  private FlashMessage $notes;

  public function __construct(UserRepository $userData, FlashMessage $notes)
  {
    $this->userData = $userData;
    $this->notes = $notes;
  }

  public function validate(array $data): bool
  {
    $valid = true;

    $csrfToken = $data['csrf'] ?? '';
    if (!check_csrf($csrfToken)) {
      $this->notes->renderError('Неверный токен безопасности');
      $valid = false;
    } 

    $email = isset($data['email']) ? trim(strtolower($data['email'])) : '';

    if ($email === '') {
      $this->notes->renderError('Введите email');
      $valid = false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $this->notes->renderError('Некорректный формат email');
      $valid = false;
    } elseif ($email) {
      $isUserInBlock = $this->userData->findBlockedUserByEmail($email);

      if ($isUserInBlock) {
        $this->notes->renderError('Ошибка, невозможно оформить заказ для этого email.');
        $valid = false;
      }

    } elseif ( empty(trim($data['name'])) ) {
      $_SESSION['errors'][] = ['title' => 'Поле "Имя" пустое. Заполните данные для отправки.'];
    } elseif ( empty(trim($data['phone'])) ) {
        $_SESSION['errors'][] = ['title' => 'Поле "Телефон" пустое. Заполните данные для отправки.'];
    }  else if ( empty(trim($data['address'])) ) {
        $_SESSION['errors'][] = ['title' => 'Поле "Адрес" пустое. Заполните данные для отправки.'];
    } 

    return $valid;
  }
}

