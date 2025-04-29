<?php
// Подключаем пагинацию
$pagination = pagination(5, 'brands');

//Запрос брендов в БД с сортировкой id по убыванию
$brands = R::find('brands', "ORDER BY id DESC {$pagination['sql_page_limit']}"); 

$pageTitle = "Бренды - все записи";
$pageClass = "admin-page";

ob_start();
include ROOT . "admin/templates/brands/all.tpl";
$content = ob_get_contents();
ob_end_clean();

//Шаблон страницы
include ROOT . "admin/templates/template.tpl";