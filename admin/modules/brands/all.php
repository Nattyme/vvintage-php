<?php
  // Подключаем readbean
  use RedBeanPHP\R; 

  // Задаем название страницы и класс
  $pageTitle = "Бренды - все записи";
  $pageClass = "admin-page";

  // Получаем данные из GET-запроса
  $searchQuery = $_GET['query'] ?? '';

  $where = [];
  $params = [];

  // Поиск по названию бренда
  if ($searchQuery !== '') {
    $where[] = 'LOWER(title) LIKE LOWER(?)';
    $params[] = '%' . $searchQuery . '%';
  }

  // Формируем WHERE для SQL запроса
  $whereSql = '';
  if (!empty($where)) {
    $whereSql = 'WHERE ' . implode(' AND ', $where);
  }

  // Считаем общее количество брендов с фильтрами
  $sqlCount = "SELECT COUNT(*) FROM `brands` $whereSql";
  $brandsCount = R::getCell($sqlCount, $params);

  // Подключаем пагинацию
  $pagination = pagination(5, 'brands');
  // $pagination = pagination(5, 'brands', $where, $params);

  $sql = "$whereSql ORDER BY id DESC {$pagination['sql_page_limit']}";
  //Запрос брендов в БД с сортировкой id по убыванию
  $brands = R::find('brands', $sql, $params); 

  ob_start();
  include ROOT . "admin/templates/brands/all.tpl";
  $content = ob_get_contents();
  ob_end_clean();

  //Шаблон страницы
  include ROOT . "admin/templates/template.tpl";