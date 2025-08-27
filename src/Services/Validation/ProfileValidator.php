<?php
declare(strict_types=1);

namespace Vvintage\Services\Validation;

use Vvintage\Repositories\User\UserRepository;
use Vvintage\Services\Base\BaseService;

final class ProfileValidator extends BaseService
{

  private const AVATAR_MIN_SIZE = [160, 160]; // ширина, высота
  private const AVATAR_MAX_SIZE_MB = 12;
  private const ALLOWED_MIMES = ['image/jpeg', 'image/png', 'image/gif']; 


  public function __construct()
  {
    parent::__construct(); // Важно!
  }

  // public function validateLogin()
  // {
  //    // Проверка на то, что юзер залогинен
  //   if( isset($_SESSION['login']) && $_SESSION['login'] === 1) {
  //     // Юзер залогинен. Проверка на роль - пользователь или админ
  //     if( $_SESSION['logged_user']['role'] === 'user') {
  //       // Это обычный пользователь
  //       // Загружаем пользователя
  //       $user = R::load('users', $_SESSION['logged_user']['id']);

  //       //Загружаем адрес доставки
  //       $userDelivery = R::findOne('address', ' user_id = ? ', [$_SESSION['logged_user']['id']]);
    
  //       updateUserAndGoToProfile($user);  //Обновляем данные пользователя
  //       updateUserDeliveryAndGoToProfile($userDelivery); //Обновляем данные доставки  пользователя
  //     } else if ( $_SESSION['logged_user']['role'] === 'admin') {
  
  //       // Это администратор сайта. Делаем проверку на доп парам - ID пользователя для редактирования
  //       if ( isset($uriGet) && $uriGet !== $_SESSION['logged_user']['id']) {
  //         //Редакт. чужого профиля. 
  //         $user = R::load('users', intval($uriGet) ); // Загружаем данные о профиле
  //         //Обновляем данные пользователя
  //         updateUserAndGoToProfile($user);
  //       } else {
  //         // Редактирование своего профиля
  //         $user = R::load('users', $_SESSION['logged_user']['id']);
      
  //         //Загружаем адрес доставки
  //         $userDelivery = R::findOne('address', ' user_id = ? ', [$_SESSION['logged_user']['id']]);

  //         updateUserAndGoToProfile($user);  //Обновляем данные пользователя
  //         updateUserDeliveryAndGoToProfile($userDelivery); //Обновляем данные доставки  пользователя
  //       }
  //     }
  //   } else {
  //     header('Location: ' . HOST . 'login');
  //     exit();
  //   }

  // }

  public function validateEdit(array $data): bool 
  {

    $valid = true;

    $csrfToken = $data['csrf'] ?? '';
    if (!check_csrf($csrfToken)) {
      $this->flash->pushError('Неверный токен безопасности');
      $valid = false;
    } 

    $email = trim( strtolower($data['email']) ?? '');
    if ($email === '') {
      $this->flash->pushError('Поле email не может быть пустым');
      $valid = false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $this->flash->pushError('Некорректный формат email');
      $valid = false;
    }

    $name = trim( strtolower($data['name']) ?? '');
    if ($name === '') {
      $this->flash->pushError('Поле "имя пользователя" не должно быть пустым.');
      $valid = false;
    } elseif (is_numeric($name)) {
      $this->flash->pushError('Некорректный формат имени. Имя пользователя не может состоять только из цифр.');
      $valid = false;
    } 

    $surname = trim( strtolower($data['surname']) ?? '');
    if ($surname === '') {
      $this->flash->pushError('Поле фамилии не должно быть пустым.');
      $valid = false;
    } elseif (is_numeric($surname)) {
      $this->flash->pushError('Некорректный формат фамилии. Фамилия пользователя не может состоять только из цифр.');
      $valid = false;
    } 

    $country = trim( strtolower($data['country']) ?? '');
    if (is_numeric($country)) {
      $this->flash->pushError('Некорректный формат страны. Поле не может состоять только из цифр.');
      $valid = false;
    } 

    $city = trim( strtolower($data['city']) ?? '');
    if (is_numeric($city)) {
      $this->flash->pushError('Некорректный формат города. Поле не может состоять только из цифр.');
      $valid = false;
    } 

    $phone = trim( strtolower($data['phone']) ?? '');
    if ($phone !== '' && !preg_match('/^\+?\d{10,15}$/', $phone)) {
        $this->flash->pushError('Некорректный номер телефона. Введите номер от в формате: +7901123456');
        $valid = false;
    }


    return $valid;
  }


  public function validateEditAvatar($file): bool 
  {
      $valid = true;

      // 1. Записываем парам-ры файла в переменные
      $fileTmpLoc = $file['tmp_name'];
      $fileSize = $file['size'];
      $fileErrorMsg = $file['error'];

      // 1. Получаем ширину и высоту файла, mime 
      $info = getimagesize($fileTmpLoc);
      $width = $info[0];
      $height = $info[1];
      $mime = $info['mime'];

      if ($width < self::AVATAR_MIN_SIZE[0] || $height < self::AVATAR_MIN_SIZE[1] ) {
        $this->flash->pushError('Изображение слишком маленького размера', 'Загрузите изображение с размерами от 160x160 и более.');
        $valid = false;
      }

      // 2.2 Проверка на большой вес файла изображения
      if ($fileSize > (self::AVATAR_MAX_SIZE_MB * 1024 * 1024)) {
        $this->flash->pushError('Файл изображения не должен быть более 12 Mb');
        $valid = false;
      }

      // 2.3 Проверка на формат файла
      if (!in_array($mime, self::ALLOWED_MIMES)) {
        $this->flash->pushError('Недопустимый формат файла', 'Файл изображения должен быть в формате gif, jpg, jpeg или png.');
        $valid = false;
      }

      // 2.4 Проверка на иную ошибку
      if ($fileErrorMsg == 1) {
        $this->flash->pushError('При загрузке файла произошла ошибка. Повторите попытку.');
        $valid = false;
      }

      return $valid;
  }


}