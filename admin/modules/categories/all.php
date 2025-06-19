<?php
  // Подключаем readbean
  use RedBeanPHP\R; 
  
  // Задаем название страницы и класс
  $pageTitle = "Категории - все записи";
  $pageClass = "admin-page";

  // Получаем данные из GET-запроса
  $searchQuery = $_GET['query'] ?? '';
  $filterSection = $_GET['action'] ?? ''; // имя селекта - action

  $where = [];
  $params = [];

  // Поиск по названию категории (child.title)
  if ($searchQuery !== '') {
      $where[] = 'child.title LIKE ?';
      $params[] = '%' . $searchQuery . '%';
  }

  // Фильтр по разделу (главной категории, parent_id)
  if ($filterSection !== '' && $filterSection !== '0') {
      $where[] = 'child.parent_id = ?';
      $params[] = $filterSection;
  }

  // Формируем WHERE для SQL запроса
  $whereSql = '';
  if (!empty($where)) {
      $whereSql = 'WHERE ' . implode(' AND ', $where);
  }

  // Подключаем пагинацию с параметрами
  $pagination = pagination(5, 'categories', [$whereSql ? substr($whereSql, 6) : '', $params]);

  // Считаем общее количество категорий с фильтрами
  $sqlCount = "SELECT COUNT(*) FROM categories child $whereSql";
  $catsCount = R::getCell($sqlCount, $params);  // количество записей с условиями


  // Запрос для получения категорий с фильтрами и пагинацией
  $sqlQuery = 'SELECT
                  child.id,
                  child.title AS child_title,
                  child.parent_id,
                  parent.title AS parent_title
                FROM categories child
                LEFT JOIN categories parent ON child.parent_id = parent.id
                ' . $whereSql . '
                ORDER BY child.id DESC ' . $pagination["sql_page_limit"];

  $cats = R::getAll($sqlQuery, $params);

  // Главные категории для селекта
  $mainCats = R::find('categories', 'parent_id IS NULL');



  ob_start();
  include ROOT . "admin/templates/categories/all.tpl";
  $content = ob_get_contents();
  ob_end_clean();

  //Шаблон страницы
  include ROOT . "admin/templates/template.tpl";