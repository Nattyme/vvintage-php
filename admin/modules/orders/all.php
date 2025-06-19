<?php
  // Подключаем readbean
  use RedBeanPHP\R; 

  // Подключаем пагинацию
  $pagination = pagination(8, 'orders');

  // Получаем данные из GET-запроса
  $searchQuery = $_GET['query'] ?? '';

  //Запрос постов в БД с сортировкой id по убыванию
  $orders = R::find('orders', "ORDER BY id DESC {$pagination['sql_page_limit']}");

  $pageTitle = "Заказы - все записи";
  $pageClass = "admin-page";
  // Центральный шаблон для модуля
  ob_start();
  include ROOT . "admin/templates/orders/all.tpl";
  $content = ob_get_contents();
  ob_end_clean();

  //Шаблон страницы
  include ROOT . "admin/templates/template.tpl";