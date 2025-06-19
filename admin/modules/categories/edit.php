<?php
  // Подключаем readbean
  use RedBeanPHP\R; 
  
  // Задаем название страницы и класс
  $pageTitle = "Категории - редактирование";
  $pageClass = "admin-page";

  if( isset($_POST['submit'])) {
    // Проверка токена
    if (!check_csrf($_POST['csrf'] ?? '')) {
      $_SESSION['errors'][] = ['error', 'Неверный токен безопасности'];
    }

    // Проверка на заполненность названия
    if( trim($_POST['title']) == '' ) {
      $_SESSION['errors'][] = ['title' => 'Введите заголовок категории'];
    } 

    // Если нет ошибок
    if ( empty($_SESSION['errors'])) {
      $cat = R::load('categories', $_GET['id']);
      $cat->title = $_POST['title'];
    
      R::store($cat);
      
      $_SESSION['success'][] = ['title' => 'Категория успешно обновлена.'];
      
      header('Location: ' . HOST . 'admin/category');
      exit();
    }
  }

  // Запрос постов в БД с сортировкой id по убыванию
  $cat = R::load('categories', $_GET['id']); 

  ob_start();
  include ROOT . "admin/templates/categories/edit.tpl";
  $content = ob_get_contents();
  ob_end_clean();

  //Шаблон страницы
  include ROOT . "admin/templates/template.tpl";