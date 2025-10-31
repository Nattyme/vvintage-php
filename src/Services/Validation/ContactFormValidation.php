<?php
declare(strict_types=1);

namespace Vvintage\Services\Validation;

class ContactFormValidation
{
    private array $errors = [];

    static public function validate(array $data): array 
    {
      $clean = [];
      $errors = [];

      // ИМЯ
      $clean['name'] = trim($data['name'] ?? '');
      if ( $clean['name'] === '') {
        $errors['name'][] = 'Поле имени не может быть пустым';
      } elseif (!is_string( $clean['name'])) {
          $errors['name'][] = 'Поле имени должно быть строкой';
      } elseif (!preg_match('/^[\p{L}\d\s]+$/u',  $clean['name'])) {
          $errors['name'][] = 'Имя может содержать только буквы и пробелы';
      }

      // ===== Телефон ===== // не обязательный
      $clean['phone'] = trim($data['phone'] ?? '');
      if ($clean['phone'] !== '') { 
          // Разрешаем цифры, пробелы, скобки, +, -
          if (!preg_match('/^\+?\d[\d\s\-\(\)]{4,20}$/', $clean['phone'])) {
              $errors['phone'][] = 'Некорректный формат телефона';
          }
      }


      // EMAIL
      $clean['email'] = trim( strtolower($data['email']) ?? '');
      if ($clean['email'] === '') {
        $errors['email'][] = 'Введите email';
        $valid = false;
      } elseif (!filter_var($clean['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'][] = 'Некорректный формат email';
        $valid = false;
      } 

      // message
      $clean['message'] = trim($data['message'] ?? '');
      if ($clean['message'] === '') {
          $errors['message'][] = 'Сообщение не может быть пустым';
      } elseif (mb_strlen($clean['message']) < 20) {
        $errors['message'][] = 'Для сообщения может быть не менее 20 символов';
      } 
      elseif (mb_strlen($clean['message']) > 1000) {
        $errors['message'][] = 'Сообщение слишком длинное (максимум 1000 символов)';
      }



      return [
        'errors' => $errors,
        'data' => $clean
      ];
    }




}