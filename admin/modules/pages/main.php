<?php
$pageTitle = "Редактирование - главная страница";
$pageClass = "admin-page";


// Центральный шаблон для модуля
ob_start();
include ROOT . "admin/templates/pages/main.tpl";
$content = ob_get_contents();
ob_end_clean();

//Шаблон страницы
include ROOT . "admin/templates/template.tpl";