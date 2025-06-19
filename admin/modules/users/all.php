<?php
  // Подключаем readbean
  use RedBeanPHP\R; 

  // Подключаем пагинацию
  $pagination = pagination(2, 'users');

  //Запрос пользователей из БД с сортировкой id по убыванию
  $usersDB = R::find('users', 'ORDER BY id DESC'); 

  //Запрос постов в БД с сортировкой id по убыванию
  $usersDB = R::find('users', "ORDER BY id DESC {$pagination['sql_page_limit']}");

  $users = array();

  foreach ($usersDB as $current_user) {
    $user['id'] = $current_user['id'];
    $user['name'] = $current_user['name'];
    $user['email'] = $current_user['email'];
    $user['role'] = $current_user['role'];

    // Считаем кол-во комментариев пользователя
    $user['comments'] = R::count( 'comments', ' user LIKE ? ', [  $current_user['id'] ] );;

    // Добавляем данные пользователя в массив
    $users[] = $user;
  }


  $pageTitle = "Пользователи - все записи";
  $pageClass = "admin-page";

  ob_start();
  include ROOT . "admin/templates/users/all.tpl";
  $content = ob_get_contents();
  ob_end_clean();

  //Шаблон страницы
  include ROOT . "admin/templates/template.tpl";