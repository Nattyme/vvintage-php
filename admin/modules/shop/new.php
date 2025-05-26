<?php
  // Задаем название страницы и класс
  $pageTitle = "Добавить новый товар";
  $pageClass = "admin-page";

  // Проверка токена чере js!!!
  // if (!check_csrf($_POST['csrf'] ?? '')) {
  //   $_SESSION['errors'][] = ['error', 'Неверный токен безопасности'];
  // }
  
  // Центральный шаблон для модуля
  ob_start();
  include ROOT . "admin/templates/shop/new.tpl";
  $content = ob_get_contents();
  ob_end_clean();

  //Шаблон страницы
  include ROOT . "admin/templates/template.tpl";
