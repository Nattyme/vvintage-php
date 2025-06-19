<?php
  // Подключаем readbean
  use RedBeanPHP\R; 
  
  if ( isset($_POST['submit'])) {
    // Проверка на заполненность названия
    if( trim($_POST['contacts_title']) == '' ) {
      $_SESSION['errors'][] = ['title' => 'Введите заголовок контактов'];
    } 

    // Проверка на заполненность содержимого
    if( trim($_POST['contacts_text']) == '' ) {
      $_SESSION['errors'][] = ['title' => 'Заполните содержимое контактов'];
    } 

    // Если нет ошибок
    if ( empty($_SESSION['errors'])) {
      function trimElement ($item) {
        return trim($item);
      }

      // Обходим массив и удаляем пробелы
      $_POST = array_map('trimElement', $_POST);

      $res[] = R::exec('UPDATE `settings` SET VALUE = ? WHERE name = ? ', [$_POST['about_title'], 'about_title']);
      $res[] = R::exec('UPDATE `settings` SET VALUE = ? WHERE name = ? ', [$_POST['about_text'], 'about_text']);

      $res[] = R::exec('UPDATE `settings` SET VALUE = ? WHERE name = ? ', [$_POST['services_title'], 'services_title']);
      $res[] = R::exec('UPDATE `settings` SET VALUE = ? WHERE name = ? ', [$_POST['services_text'], 'services_text']);

      $res[] = R::exec('UPDATE `settings` SET VALUE = ? WHERE name = ? ', [$_POST['contacts_title'], 'contacts_title']);
      $res[] = R::exec('UPDATE `settings` SET VALUE = ? WHERE name = ? ', [$_POST['contacts_text'], 'contacts_text']);

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

  $settingsContacts = R::find('settings', ' section LIKE ? ', ['contacts']); // Получаем массив с нужными настройками

  //  Для вывода в шаблоне нашими ключами должны стать значения из поля 'name':
  // about_title, abput_text, services_title и т д
  // Значить нужно сформир-ть новый массив с такими ключами из 'name' и значениями из 'value'
  $contacts = []; // Создаем массив кот. наполним

  foreach ($settingsContacts as $key => $value) {
    $contacts[$value['name']] = $value['value'];
  }

  $pageTitle = "Контакты - редактирвание";
  $pageClass = "admin-page";
  //Шаблон страницы
  ob_start();
  include ROOT . "admin/templates/contacts/edit.tpl";
  $content = ob_get_contents();
  ob_end_clean();

  include ROOT . "admin/templates/template.tpl";
