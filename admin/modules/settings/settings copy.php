<?php 
  // Подключаем readbean
  use RedBeanPHP\R; 
  if ( isset($_POST['submit'])) {
    // Проверка на заполненность названия
    if( trim($_POST['site_title']) == '' ) {
      $_SESSION['errors'][] = ['title' => 'Введите название сайта'];
    } 

    // Проверка на заполненность содержимого
    if( trim($_POST['copyright_name']) == '' ) {
      $_SESSION['errors'][] = ['title' => 'Заполните поле "Копирайт первая строка'];
    } 

    // Проверка на заполненность кол-ва карточек в магазине
    if( trim($_POST['card_on_page_shop']) == '' ||  $_POST['card_on_page_shop'] <= 0) {
      $_SESSION['errors'][] = ['title' => 'Количество товаров в магазине должно быть больше "0" '];
    } 

    // Проверка на заполненность кол-ва постов в блоге
    if( trim($_POST['card_on_page_blog']) == '' ||  $_POST['card_on_page_blog'] <= 0) {
      $_SESSION['errors'][] = ['title' => 'Количество постов в блоге должно быть больше "0" '];
    } 

    // Проверка на заполненность кол-ва проектов в портфолио
    if( trim($_POST['card_on_page_portfolio']) == '' ||  $_POST['card_on_page_portfolio'] <= 0) {
      $_SESSION['errors'][] = ['title' => 'Количество проектов в портфолио должно быть больше "0" '];
    } 

    // Если нет ошибок
    if ( empty($_SESSION['errors'])) {
      function trimElement ($item) {
        return trim($item);
      }

      $_POST = array_map('trimElement', $_POST);

      $res[] = R::exec('UPDATE `settings` SET VALUE = ? WHERE name = ? ', [$_POST['site_title'], 'site_title']);
      $res[] = R::exec('UPDATE `settings` SET VALUE = ? WHERE name = ? ', [$_POST['site_slogan'], 'site_slogan']);

      $res[] = R::exec('UPDATE `settings` SET VALUE = ? WHERE name = ? ', [$_POST['copyright_name'], 'copyright_name']);
      $res[] = R::exec('UPDATE `settings` SET VALUE = ? WHERE name = ? ', [$_POST['copyright_year'], 'copyright_year']);

      $_POST['status_on'] = isset($_POST['status_on']) ? $_POST['status_on'] : NULL;

      $res[] = R::exec('UPDATE `settings` SET VALUE = ? WHERE name = ? ', [$_POST['status_on'], 'status_on']);
      $res[] = R::exec('UPDATE `settings` SET VALUE = ? WHERE name = ? ', [$_POST['status_label'], 'status_label']);
      $res[] = R::exec('UPDATE `settings` SET VALUE = ? WHERE name = ? ', [$_POST['status_text'], 'status_text']);
      $res[] = R::exec('UPDATE `settings` SET VALUE = ? WHERE name = ? ', [$_POST['status_link'], 'status_link']);

      $res[] = R::exec('UPDATE `settings` SET VALUE = ? WHERE name = ? ', [$_POST['youtube'], 'youtube']);
      $res[] = R::exec('UPDATE `settings` SET VALUE = ? WHERE name = ? ', [$_POST['instagram'], 'instagram']);
      $res[] = R::exec('UPDATE `settings` SET VALUE = ? WHERE name = ? ', [$_POST['facebook'], 'facebook']);
      $res[] = R::exec('UPDATE `settings` SET VALUE = ? WHERE name = ? ', [$_POST['vkontakte'], 'vkontakte']);
      $res[] = R::exec('UPDATE `settings` SET VALUE = ? WHERE name = ? ', [$_POST['dzen'], 'dzen']);

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

  $pageTitle = "Настройки - редактирвание";
  $pageClass = "admin-page";
  //Шаблон страницы
  ob_start();
  include ROOT . "admin/templates/settings/settings.tpl";
  $content = ob_get_contents();
  ob_end_clean();

  include ROOT . "admin/templates/template.tpl";