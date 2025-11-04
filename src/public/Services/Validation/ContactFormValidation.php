<?php
declare(strict_types=1);

namespace Vvintage\public\Services\Validation;

class ContactFormValidation
{
    static public function validate(array $data): array 
    {
      $clean = [];

      $csrfToken = $data['csrf'] ?? '';
      if (!check_csrf($csrfToken)) throw new \Exception('Неверный токен безопасности');

      // ИМЯ
      $clean['name'] = trim($data['name'] ?? '');
      if ( $clean['name'] === '') {
        throw new \Exception('Необходимо указать имя');
      }  elseif (!preg_match('/^[\p{L}\d\s]+$/u',  $clean['name'])) {
         throw new \Exception('Имя может содержать только буквы и пробелы');
      }

      // ===== Телефон ===== // не обязательный
      $clean['phone'] = trim($data['phone'] ?? '');
      if ($clean['phone'] !== '') { 
          // Разрешаем цифры, пробелы, скобки, +, -
          if (!preg_match('/^\+?\d[\d\s\-\(\)]{4,20}$/', $clean['phone'])) {
            throw new \Exception('Некорректный формат телефона');
          }
      }


      // EMAIL
      $clean['email'] = trim( strtolower($data['email']) ?? '');
      if ($clean['email'] === '') {
        throw new \Exception('Введите email');
      } elseif (!filter_var($clean['email'], FILTER_VALIDATE_EMAIL)) {
        throw new \Exception('Некорректный формат email');
      } 

      // message
      $clean['message'] = trim($data['message'] ?? '');
      if ($clean['message'] === '') {
        throw new \Exception('Сообщение не может быть пустым');
      } elseif (mb_strlen($clean['message']) < 20) {
        throw new \Exception('Длинна сообщения должна быть не менее 20 символов');
      } 
      elseif (mb_strlen($clean['message']) > 1000) {
        throw new \Exception('Сообщение слишком длинное (максимум 1000 символов)');
      }

      return  $clean; // вернем очищенные данные
    }




}