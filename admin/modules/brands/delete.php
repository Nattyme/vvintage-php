<?php
  // Подключаем readbean
  use RedBeanPHP\R; 
  
  // Задаем название страницы и класс
  $pageTitle = "Бренды - удалить запись";
  $pageClass = "admin-page";

  $brand = R::load('brands', $_GET['id']); 

  if ( isset($_POST['submit']) ) {
    // Проверка токена
    if (!check_csrf($_POST['csrf'] ?? '')) {
      $_SESSION['errors'][] = ['error', 'Неверный токен безопасности'];
    }

    // Если нет ошибок
    if ( empty($_SESSION['errors'])) {
      R::trash($brand); 
    
      $_SESSION['success'][] = ['title' => 'Бренд был успешно удален.'];
      header('Location: ' . HOST . 'admin/brand');
      exit();
    }


  }


  ob_start();
  include ROOT . "admin/templates/brands/delete.tpl";
  $content = ob_get_contents();
  ob_end_clean();

  //Шаблон страницы
  include ROOT . "admin/templates/template.tpl";