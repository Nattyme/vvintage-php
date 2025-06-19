<?php
  // Подключаем readbean
  use RedBeanPHP\R; 
  
  // Задаем название страницы и класс
  $pageTitle = 'Бренды - редактирование';
  $pageClass = 'admin-page';

  // Задаем название страницы и класс
  if( isset($_POST['submit'])) {
    // Проверка токена
    if (!check_csrf($_POST['csrf'] ?? '')) {
      $_SESSION['errors'][] = ['error', 'Неверный токен безопасности'];
    }

    // Проверка на заполненность названия
    if( trim($_POST['title']) == '' ) {
      $_SESSION['errors'][] = ['title' => 'Введите название бренда'];
    } 

    // Если нет ошибок
    if ( empty($_SESSION['errors'])) {
      $brand = R::load('brands', $_GET['id']);
      $brand->title = $_POST['title'];

      R::store($brand);

      $_SESSION['success'][] = ['title' => 'Бренд успешно обновлен.'];
    }
  }

  // Запрос постов в БД с сортировкой id по убыванию
  $brand = R::load('brands', $_GET['id']); 

  ob_start();
  include ROOT . 'admin/templates/brands/edit.tpl';
  $content = ob_get_contents();
  ob_end_clean();

  //Шаблон страницы
  include ROOT . 'admin/templates/template.tpl';