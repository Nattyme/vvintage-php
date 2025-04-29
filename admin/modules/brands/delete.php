<?php
$brand = R::load('brands', $_GET['id']); 

if ( isset($_POST['submit']) ) {
  R::trash($brand); 
  
  $_SESSION['success'][] = ['title' => 'Бренд был успешно удален.'];
  header('Location: ' . HOST . 'admin/brand');
  exit();
}

$pageTitle = "Бренды - удалить запись";
$pageClass = "admin-page";


ob_start();
include ROOT . "admin/templates/brands/delete.tpl";
$content = ob_get_contents();
ob_end_clean();

//Шаблон страницы
include ROOT . "admin/templates/template.tpl";