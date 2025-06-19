<?php
  // Подключаем readbean
  use RedBeanPHP\R; 

  // Получаем сообщение
  $message = R::load('messages', $_GET['id']); 

  if ($message['status'] === 'new') {
    $message->status = NULL;
    R::store($message);
    $messagesNewCounter = R::count('messages', ' status = ?', ['new']);
  }

  $pageTitle = "Сообщение";
  $pageClass = "admin-page";
  ob_start();
  include ROOT . "admin/templates/messages/single.tpl";
  $content = ob_get_contents();
  ob_end_clean();

  //Шаблон страницы
  include ROOT . "admin/templates/template.tpl";