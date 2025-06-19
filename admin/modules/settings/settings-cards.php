<?php
  // Подключаем readbean
  use RedBeanPHP\R; 
    
  if ( isset($_POST['submit'])) {

    // Проверка на заполненность кол-ва карточек в магазине
    if( trim($_POST['card_on_page_shop']) == '' ||  $_POST['card_on_page_shop'] <= 0) {
      $_SESSION['errors'][] = ['title' => 'Количество товаров в магазине должно быть больше "0" '];
    } 

    // Проверка на заполненность кол-ва постов в блоге
    if( trim($_POST['card_on_page_blog']) == '' ||  $_POST['card_on_page_blog'] <= 0) {
      $_SESSION['errors'][] = ['title' => 'Количество постов в блоге должно быть больше "0" '];
    } 

    // Если нет ошибок
    if ( empty($_SESSION['errors'])) {
      function trimElement ($item) {
        return trim($item);
      }

      $res = [];

      $_POST = array_map('trimElement', $_POST);

      $res[] = R::exec('UPDATE `settings` SET VALUE = ? WHERE name = ? ', [$_POST['card_on_page_shop'], 'card_on_page_shop']);
      $res[] = R::exec('UPDATE `settings` SET VALUE = ? WHERE name = ? ', [$_POST['card_on_page_blog'], 'card_on_page_blog']);
      $res[] = R::exec('UPDATE `settings` SET VALUE = ? WHERE name = ? ', [$_POST['card_on_page_portfolio'], 'card_on_page_portfolio']);

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
      }
    }
  }

  $settingsArray = R::find('settings', ' section LIKE ? ', ['settings']);

  $settings = [];
  foreach ($settingsArray as $key => $value) {
    $settings[$value['name']] = $value['value'];
  }

  $pageTitle = "Настройки - карточки на странице";
  $pageClass = "admin-page";
  //Шаблон страницы
  ob_start();
  include ROOT . "admin/templates/settings/settings.tpl";
  $content = ob_get_contents();
  ob_end_clean();

  include ROOT . "admin/templates/template.tpl";