<?php
if( isset($_POST['submit'])) {
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

$pageTitle = "Бренды. Редактировать бренд {$brand['title']}";
$pageClass = "admin-page";

ob_start();
include ROOT . "admin/templates/brands/edit.tpl";
$content = ob_get_contents();
ob_end_clean();

//Шаблон страницы
include ROOT . "admin/templates/template.tpl";