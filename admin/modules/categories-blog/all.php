<?php
  // Подключаем readbean
  use RedBeanPHP\R; 
  
  // Задаем название страницы и класс
  $pageTitle = "Категории блога";
  $pageClass = "admin-page";

  // Подключаем пагинацию с параметрами
  $pagination = pagination(5, 'blogcategories');

  // Получаем категории блога
  $cats = R::find('blogcategories', "ORDER BY id DESC {$pagination['sql_page_limit']}");

  ob_start();
  include ROOT . "admin/templates/categories-blog/all.tpl";
  $content = ob_get_contents();
  ob_end_clean();

  //Шаблон страницы
  include ROOT . "admin/templates/template.tpl";