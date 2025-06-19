<?php
// Подключаем readbean
use RedBeanPHP\R; 

$post = R::load('posts', $_GET['id']); 

if( isset($_POST['postDelete']) ) {
  // Удаление обложки
  if ( !empty($post['cover']) ) {

    // Удадить файлы обложки с сервера
    $coverFolderLocation = ROOT . 'usercontent/blog/';
    unlink($coverFolderLocation . $post->cover);
    unlink($coverFolderLocation . $post->coverSmall);
  }

  R::trash($post);
  
  $_SESSION['success'][] = ['title' => 'Пост был успешно удалён.'];
  header('Location: ' . HOST . 'admin/blog');
  exit();
}

// Центральный шаблон для модуля. Передаем шаблон текущ стараницы и гланвый шаблон, название страницы и класс(елси есть)
renderTemplateUseBufer(
  'admin/templates/blog/delete.tpl', 
  'admin/templates/template.tpl', 
  ['title' => 'Блог - удалить пост', 'class' => 'admin-page']
);