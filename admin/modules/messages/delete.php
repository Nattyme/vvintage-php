<?php
  // Подключаем readbean
  use RedBeanPHP\R; 
  
  // Задаем название страницы и класс
  $pageTitle = "Сообщения - удаление";
  $pageClass = "admin-page";

  $message = R::load('messages', $_GET['id']);


  if( isset($_POST['submit']) ) {
    dd('hey');
    // Проверка токена
    if (!check_csrf($_POST['csrf'] ?? '')) {
      $_SESSION['errors'][] = ['error', 'Неверный токен безопасности'];
    }

    // Если нет ошибок
    if ( empty($_SESSION['errors'])) {

      // Удаление файла
      if ( !empty($message['file_name_src']) ) {

        // Удадить файлы с сервера
        $fileFolderLocation = ROOT . 'usercontent/contact-form/';
        unlink($fileFolderLocation . $message->file_name_src);
      }

      R::trash($message);
      $_SESSION['success'][] = ['title' => 'Сообщение было успешно удалено.'];
     
      header('Location: ' . HOST . 'admin/messges');
      exit();
    }
  }


  
  // Центральный шаблон для модуля
  ob_start();
  include ROOT . "admin/templates/messages/delete.tpl";
  $content = ob_get_contents();
  ob_end_clean();

  //Шаблон страницы
  include ROOT . "admin/templates/template.tpl";
