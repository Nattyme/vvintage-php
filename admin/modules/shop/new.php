<?php
  $pageTitle = "Добавить новый товар";
  $pageClass = "admin-page";
  // Центральный шаблон для модуля
  ob_start();
  include ROOT . "admin/templates/shop/new.tpl";
  $content = ob_get_contents();
  ob_end_clean();

  //Шаблон страницы
  include ROOT . "admin/templates/template.tpl";
