<?php 
  // Подключаем readbean
  use RedBeanPHP\R; 
  if ( isset($_POST['submit'])) {

    // Проверка на заполненность названия
    if( trim($_POST['site_title']) == '' ) {
      $_SESSION['errors'][] = ['title' => 'Введите название сайта'];
    } 

    // Проверка на заполненность слогана
    if( trim($_POST['site_slogan']) == '' ) {
      $_SESSION['errors'][] = ['title' => 'Введите название сайта'];
    } 

    // Проверка на заполненность содержимого
    // if( trim($_POST['copyright_name']) == '' ) {
    //   $_SESSION['errors'][] = ['title' => 'Заполните поле "Копирайт первая строка'];
    // } 

    // Если нет ошибок
    if ( empty($_SESSION['errors'])) {
      function trimElement ($item) {
        return trim($item);
      }

      $res = [];

      $_POST = array_map('trimElement', $_POST);

      $res[] = R::exec('UPDATE `settings` SET VALUE = ? WHERE name = ? ', [$_POST['site_title'], 'site_title']);
      $res[] = R::exec('UPDATE `settings` SET VALUE = ? WHERE name = ? ', [$_POST['site_slogan'], 'site_slogan']);

      $fail = false;
      // Если в массиве вернулось значение пустого массива  - ошибка
      foreach ($res as $value) {
        if (is_array($value) && empty($value)) {
          $fail = true;
        } 
      }

      if ($fail) {
        $_SESSION['errors'][] = [
          'title' => 'Данные не сохранились',
          'desc' => 'Если ошибка повторяется, обратитесь к администратору сайта'
        ];
      } else {
        $_SESSION['success'][] = ['title' => 'Все изменения успешно сохранены.'];
        header('Location: ' . HOST . 'admin/settings-main');
        exit;
      }
    }
  }

  $settingsArray = R::find('settings', ' section LIKE ? ', ['settings']);

  $settings = [];
  foreach ($settingsArray as $key => $value) {
    $settings[$value['name']] = $value['value'];
  }

  $pageTitle = "Настройки - основные";
  $pageClass = "admin-page";
  //Шаблон страницы
  ob_start();
  include ROOT . "admin/templates/settings/settings.tpl";
  $content = ob_get_contents();
  ob_end_clean();

  include ROOT . "admin/templates/template.tpl";