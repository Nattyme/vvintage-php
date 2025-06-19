<?php
  // Подключаем readbean
  use RedBeanPHP\R; 
  
  // Получаем комментарий
  $sqlQuery = 'SELECT 
                  p.id as post_id, p.title as post_title,
                  u.id as user_id, u.name as user_name, u.surname as user_surname, u.email as user_email,
                  c.id, c.user, c.post, c.text, c.timestamp, c.status
                FROM `posts` AS p
                INNER JOIN `comments` AS c
                ON c.post = p.id
                INNER JOIN `users` AS u
                ON c.user = u.id
                WHERE c.id = ?';

  $comment = R::getRow($sqlQuery, [$_GET['id']]);

  if ($comment['status'] === 'new') {
    $comment = R::load('comments', $comment['id']);
    $comment->status = NULL;
    R::store($comment);
    $commentsNewCounter = R::count('comments', ' status = ?', ['new']);

    $comment = R::getRow($sqlQuery, [$_GET['id']]);
  }

  $pageTitle = "Комментарий";
  $pageClass = "admin-page";
  ob_start();
  include ROOT . "admin/templates/comments/single.tpl";
  $content = ob_get_contents();
  ob_end_clean();

  //Шаблон страницы
  include ROOT . "admin/templates/template.tpl";