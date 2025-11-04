<?php
declare(strict_types=1);

namespace Vvintage\Services\Validation;

use Vvintage\Repositories\User\UserRepository;


final class ProfileValidator 
{

  private const AVATAR_MIN_SIZE = [160, 160]; // ширина, высота
  private const AVATAR_MAX_SIZE_MB = 12;
  private const ALLOWED_MIMES = ['image/jpeg', 'image/png', 'image/gif']; 


  public function validateEdit(array $data): void
  {
    $csrfToken = $data['csrf'] ?? '';
    if (!check_csrf($csrfToken)) throw new \Exception('Неверный токен безопасности');

    $email = trim( strtolower($data['email']) ?? '');
    if ($email === '') {
      throw new \Exception('Поле email не может быть пустым');
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      throw new \Exception('Некорректный формат email');
    }

    $name = trim( strtolower($data['name']) ?? '');
    if ($name === '') {
      throw new \Exception('Поле "имя пользователя" не должно быть пустым.');
    } elseif (is_numeric($name)) {
      throw new \Exception('Имя пользователя не может состоять только из цифр.');
    } 

    $surname = trim( strtolower($data['surname']) ?? '');
    if ($surname === '') {
      throw new \Exception('Поле фамилии не должно быть пустым.');
    } elseif (is_numeric($surname)) {
      throw new \Exception('Некорректный формат фамилии. Фамилия пользователя не может состоять только из цифр.');
    } 

    $country = trim( strtolower($data['country']) ?? '');
    if (is_numeric($country)) throw new \Exception('Некорректный формат страны. Поле не может состоять только из цифр.');


    $city = trim( strtolower($data['city']) ?? '');
    if (is_numeric($city)) throw new \Exception('Некорректный формат города. Поле не может состоять только из цифр.');

    $phone = trim( strtolower($data['phone']) ?? '');
    if ($phone !== '' && !preg_match('/^\+?\d{10,15}$/', $phone)) throw new \Exception('Некорректный номер телефона. Введите номер от в формате: +7901123456');
  }


  public function validateEditAvatar($file): void 
  {
      // 1. Записываем парам-ры файла в переменные
      $fileTmpLoc = $file['tmp_name'];
      $fileSize = $file['size'];
      $fileErrorMsg = $file['error'];

      // 1. Получаем ширину и высоту файла, mime 
      $info = @getimagesize($fileTmpLoc); // размеры
      if ($info === false) throw new \Exception('Не удалось определить параметры изображения. Проверьте, что вы загрузили корректный файл.');

      $width = $info[0];
      $height = $info[1];
      $mime = $info['mime'];

      if ($width < self::AVATAR_MIN_SIZE[0] || $height < self::AVATAR_MIN_SIZE[1] ) {
        throw new \Exception('Изображение слишком маленького размера. Загрузите изображение с размерами от 160x160 и более.');
      }

      // 2.2 Проверка на большой вес файла изображения
      if ($fileSize > (self::AVATAR_MAX_SIZE_MB * 1024 * 1024)) throw new \Exception('Файл изображения не должен быть более 12 Mb');

      // 2.3 Проверка на формат файла
      if (!in_array($mime, self::ALLOWED_MIMES)) {
        throw new \Exception('Недопустимый формат файла. Файл изображения должен быть в формате gif, jpg, jpeg или png.');
      }

      // 2.4 Проверка на иную ошибку
      if ($fileErrorMsg == 1) {
        throw new \Exception('При загрузке файла произошла ошибка. Повторите попытку.');
      }
  }


}