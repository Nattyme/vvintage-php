<?php


// Находим под  категории, относящиеся к секции shop
$subCats = R::find('categories', 'parent_id != 0 ORDER BY title ASC');

// Получаем бренды
$brands = R::find('brands', 'ORDER BY title ASC'); 

$pageTitle = "Добавить новый товар";
$pageClass = "admin-page";
// Центральный шаблон для модуля
ob_start();
include ROOT . "admin/templates/shop/new.tpl";
$content = ob_get_contents();
ob_end_clean();

//Шаблон страницы
include ROOT . "admin/templates/template.tpl";
