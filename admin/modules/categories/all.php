<?php
// Подключаем пагинацию
$pagination = pagination(5, 'categories');
$cats = R::find('categories', "ORDER BY id DESC {$pagination['sql_page_limit']}");

// Составляем массив категории блога
$pageTitle = "Категории - все записи";
$pageClass = "admin-page";

ob_start();
include ROOT . "admin/templates/categories/all.tpl";
$content = ob_get_contents();
ob_end_clean();

//Шаблон страницы
include ROOT . "admin/templates/template.tpl";