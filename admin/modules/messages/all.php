<?php
  // Подключаем readbean
  use RedBeanPHP\R; 

  // Подключаем пагинацию
  $pagination = pagination(7, 'messages');

  //Запрос сообщений в БД с сортировкой id по убыванию
  $messages = R::find('messages', "ORDER BY id DESC {$pagination['sql_page_limit']}");

  $pageTitle = "Сообщения - все записи";
  $pageClass = "admin-page";

  // Шаблон страницы
  ob_start();
  include ROOT . "admin/templates/messages/all.tpl";
  $content = ob_get_contents();
  ob_end_clean();

  include ROOT . "admin/templates/template.tpl";