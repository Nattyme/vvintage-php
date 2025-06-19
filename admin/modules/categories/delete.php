<?php
  // Подключаем readbean
  use RedBeanPHP\R; 
  
  // Задаем название страницы и класс
  $pageTitle = "Категории - удалить запись";
  $pageClass = "admin-page";

  $cat = R::load('categories', $_GET['id']); 


  if ( isset($_POST['submit']) ) {
    // Проверка токена
    if (!check_csrf($_POST['csrf'] ?? '')) {
      $_SESSION['errors'][] = ['error', 'Неверный токен безопасности'];
    }

     // Если нет ошибок
    if ( empty($_SESSION['errors'])) {
      R::trash($cat); 
    
      $_SESSION['success'][] = ['title' => 'Категория была успешно удалена.'];
      header('Location: ' . HOST . 'admin/category');
      exit();
    }
  
  }


  ob_start();
  include ROOT . "admin/templates/categories/delete.tpl";
  $content = ob_get_contents();
  ob_end_clean();

  //Шаблон страницы
  include ROOT . "admin/templates/template.tpl";