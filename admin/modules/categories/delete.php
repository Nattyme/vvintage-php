<?php
$cat = R::load('categories', $_GET['id']); 

// Получаем  текущую секцию из сессии
$currentSection = $_SESSION['currentSection'];

if ( isset($_POST['submit']) ) {
  // Перезапиываем текущую секцию данными из БД 
  $currentSection = $cat['section'];
  R::trash($cat); 
  
  $_SESSION['success'][] = ['title' => 'Категория была успешно удалена.'];
  header('Location: ' . HOST . 'admin/category?' . $currentSection);
  exit();
}

$pageTitle = "Категории - удалить запись";
$pageClass = "admin-page";

ob_start();
include ROOT . "admin/templates/categories/delete.tpl";
$content = ob_get_contents();
ob_end_clean();

//Шаблон страницы
include ROOT . "admin/templates/template.tpl";