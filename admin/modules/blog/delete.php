<?php
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

$pageTitle = "Блог - удалить пост";
$pageClass = "admin-page";

// Центральный шаблон для модуля
ob_start();
include ROOT . "admin/templates/blog/delete.tpl";
$content = ob_get_contents();
ob_end_clean();

//Шаблон страницы
include ROOT . "admin/templates/template.tpl";
