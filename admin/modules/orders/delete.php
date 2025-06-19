<?php
  // Подключаем readbean
  use RedBeanPHP\R; 

  // Загружаем заказ по GET id
  $order = R::load('orders', $_GET['id']); 

  // Удаляем заказ
  if ( isset($_POST['submit']) ) {
    R::trash($order); 
    $_SESSION['success'][] = ['title' => 'Заказ удалён'];
    header('Location: ' . HOST . 'admin/orders');
    exit();
  }

  $pageTitle = "Удаление заказа N{$order['id']}";
  $pageClass = "admin-page";
  // Центральный шаблон для модуля
  ob_start();
  include ROOT . "admin/templates/orders/delete.tpl";
  $content = ob_get_contents();
  ob_end_clean();

  //Шаблон страницы
  include ROOT . "admin/templates/template.tpl";