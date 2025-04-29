<?php

if( isset($_POST['submit']) ) {
  // Проверка на заполненность названия
  if( trim($_POST['title']) == '' ) {
    $_SESSION['errors'][] = ['title' => 'Введите заголовок бренда'];
  } 

  if ( empty($_SESSION['errors'])) {
    $brand = R::dispense('brands');
    $brand->title = $_POST['title'];

    R::store($brand);

    $_SESSION['success'][] = ['title' => 'Бренд был успешно создан'];

    if ( isset($_SESSION['currentSection']) && $_SESSION['currentSection'] === 'admin/shop-new') {
      header('Location: ' . HOST . 'admin/shop-new');
      exit();
    } else {
      header('Location: ' . HOST . 'admin/brand');
      exit();
    }
    
  }
}

$pageTitle = "Бренды - новая запись";
$pageClass = "admin-page";

ob_start();
include ROOT . "admin/templates/brands/new.tpl";
$content = ob_get_contents();
ob_end_clean();

//Шаблон страницы
include ROOT . "admin/templates/template.tpl";