<?php
  // Подключаем readbean
  use RedBeanPHP\R; 

  // Задаем название страницы и класс
  $pageTitle = "Категория блога - новая";
  $pageClass = "admin-page";

  if( isset($_POST['submit']) ) {
    // Проверка токена
    if (!check_csrf($_POST['csrf'] ?? '')) {
      $_SESSION['errors'][] = ['error', 'Неверный токен безопасности'];
    }
    
    // Проверка на заполненность названия
    if( trim($_POST['title']) == '' ) {
      $_SESSION['errors'][] = ['title' => 'Введите заголовок категории'];
    } 

    if ( empty($_SESSION['errors'])) {
      $cat = R::dispense('blogcategories');
      $cat->title = $_POST['title'];
      R::store($cat);
      
      $_SESSION['success'][] = ['title' => 'Категория была успешно создана'];

      header('Location: ' . HOST . 'admin/category-blog');
      exit();
    }
  }

  ob_start();
  include ROOT . "admin/templates/categories-blog/new.tpl";
  $content = ob_get_contents();
  ob_end_clean();

  //Шаблон страницы
  include ROOT . "admin/templates/template.tpl";