<?php
  // Подключаем readbean
  use RedBeanPHP\R; 

  if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id']) ) {
    // Проверка запроса на удаление
    $comment = R::load('comments', $_GET['id']);

    R::trash($comment);
  }

  // Подключаем пагинацию
  $pagination = pagination(8, 'comments');

  //Запрос постов в БД с сортировкой id по убыванию
  $commentsDB = R::find('comments', "ORDER BY id DESC {$pagination['sql_page_limit']}");

  $comments = array();

  $sqlQuery = 'SELECT
                      u.id AS user_id, u.name, u.surname, u.avatar_small,
                      c.id, c.text, c.user, c.timestamp, 
                      c.status, c.post,
                      p.title, p.id AS post_id
                FROM `users` as u
                LEFT JOIN `comments` as c ON u.id = c.user
                LEFT JOIN `posts` as p ON c.post = p.id
                WHERE c.id = ?';

  foreach ($commentsDB as $current_comment) {
    $commentDB = R::getRow( $sqlQuery,[ $current_comment['id'] ]);

    //Проверка, что пользователь существует (не удаленный)
    if( $commentDB['user_id'] ) {
      $comment['id'] =  $commentDB['id'];
      $comment['status'] =  $commentDB['status'];
      $comment['user_id'] =  $commentDB['user_id'];
      $comment['avatar_small'] =  $commentDB['avatar_small'];
      $comment['name'] =  $commentDB['name'];
      $comment['surname'] =  $commentDB['surname'];
      $comment['text'] =  $commentDB['text'];
      $comment['post_id'] =  $commentDB['post_id'];
      $comment['post_id'] =  $commentDB['post_id'];
      $comment['title'] =  $commentDB['title'];
      $comment['timestamp'] =  $commentDB['timestamp'];
    }
        
    // Добавляем данные пользователя в массив
    $comments[] = $comment;
  }

  $pageTitle = "Комментарии - все записи";
  $pageClass = "admin-page";

  // Шаблон страницы
  ob_start();
  include ROOT . "admin/templates/comments/all.tpl";
  $content = ob_get_contents();
  ob_end_clean();

  include ROOT . "admin/templates/template.tpl";