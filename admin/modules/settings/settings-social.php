<?php
  // Подключаем readbean
  use RedBeanPHP\R; 
   
  if ( isset($_POST['submit'])) {

    $socialFields = ['youtube', 'instagram', 'facebook', 'vkontakte', 'dzen', 'telegram'];

    // Обойдем каждый элемент массива, если он передан в POST, то проверяем корректность ссылки
    // foreach ($socialFields as $field) {
    //   $url = trim($_POST[$field]) ?? '';

    //   if (!empty($url) && !filter_var($url, FILTER_VALIDATE_URL)) {
    //       $_SESSION['errors'][] = [
    //         'title' => 'Введите корректную ссылку',
    //         'desc' => $field
    //       ];
    //   } 
    // }

    if ( empty($_SESSION['errors'])) {
      $res = [];

      foreach ($socialFields as $field) {
        $url = trim($_POST[$field]) ?? '';

        // Сохраняем даже если пустое поле
        if (!empty($url)) {
          $res[] = R::exec('UPDATE `settings` SET VALUE = ? WHERE name = ? ', [$url, $field]);
        }
      }

      $fail = false;

      // Если в массиве вернулось значение пустого массива  - ошибка
      foreach ($res as $value) {
        if (is_array($value) && empty($value)) {
          $fail = true;
        } 
      }

      // Если ошибка
      if ($fail) {
        $_SESSION['errors'][] = [
          'title' => 'Данные не сохранились',
          'desc' => 'Если ошибка повторяется, обратитесь к администратору сайта'
        ];
      } else {
        $_SESSION['success'][] = ['title' => 'Все изменения успешно сохранены.'];
        header('Location: ' . HOST . 'admin/settings-social');
        exit;
      }
    } else {
      $_SESSION['errors'][] = [
        'title' => 'Ошибка валидации ссылок',
        'desc' => 'Ошибка валидации ссылок'
      ];
    }
  }


  $settingsArray = R::find('settings', ' section LIKE ? ', ['settings']);

  $settings = [];
  foreach ($settingsArray as $key => $value) {
    $settings[$value['name']] = $value['value'];
  }

  $pageTitle = "Настройки - cоциальные ссылки";
  $pageClass = "admin-page";

  //Шаблон страницы
  ob_start();
  include ROOT . "admin/templates/settings/settings.tpl";
  $content = ob_get_contents();
  ob_end_clean();

  include ROOT . "admin/templates/template.tpl";
