<?php
declare(strict_types=1);

namespace Vvintage\public\Services\Validation;

final class NewOrderValidator 
{

  public function validate(array $data): void
  {
    $csrfToken = $data['csrf'] ?? '';
    if (!check_csrf($csrfToken)) throw new \Exception('Неверный токен безопасности');

    $email = isset($data['email']) ? trim(strtolower($data['email'])) : '';
    if ($email === '') {
      throw new \Exception('Введите email');
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      throw new \Exception('Недопустимый формат Email');
    } elseif ( empty(trim($data['name'])) ) {
       throw new \Exception('Укажите контактное лицо');
    } elseif ( empty(trim($data['phone'])) ) {
      throw new \Exception('Укажите телефон для связи.');
    }  else if ( empty(trim($data['address'])) ) {
      throw new \Exception('Заполните адрес для доставки');
    } 
  }
}

