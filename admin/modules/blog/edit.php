<?php
// Подключаем readbean
use RedBeanPHP\R; 

$pageTitle = "Блог. Редактировать пост";
$pageClass = "admin-page";

// Получаем категории блога
$catsDB = R::find('blogcategories', "ORDER BY id DESC");

// Создаем массив для категорий shop
$cats = [];
foreach ($catsDB as $key => $value) {
  $cats[] = ['id' => $value['id'], 'title' => $value['title']];
}

if( isset($_POST['postEdit'])) {
  
  // Проверка на заполненность названия
  if( trim($_POST['title']) == '' ) {
    $_SESSION['errors'][] = ['title' => 'Введите заголовок поста'];
  } 

  // Проверка на заполненность описания
  if( trim($_POST['description']) == '' ) {
    $_SESSION['errors'][] = ['title' => 'Заполните описание поста'];
  } 

  // Проверка на заполненность содержимого
  if( trim($_POST['content']) == '' ) {
    $_SESSION['errors'][] = ['title' => 'Заполните содержимое поста'];
  } 

  // Если нет ошибок
  if ( empty($_SESSION['errors'])) {
    $post = R::load('posts', $_GET['id']);
    $post->title = $_POST['title'];
    $post->cat = $_POST['cat'];
    $post->description = $_POST['description'];
    $post->content = $_POST['content'];
    $post->editTime = time();

    // Если передано изображение - уменьшаем, сохраняем, записываем в БД
    if( isset($_FILES['cover']['name']) && $_FILES['cover']['tmp_name'] !== '') {
      //Если передано изображение - уменьшаем, сохраняем файлы в папку, получаем название файлов изображений
      $coverFileName = saveUploadedImg('cover', [600, 300], 12, 'blog', [1110, 460], [290, 230]);

      // Если новое изображение успешно загружено 
      if ($coverFileName) {
        $coverFolderLocation = ROOT . 'usercontent/blog/';
        // Если есть старое изображение - удаляем 
        if (file_exists($coverFolderLocation . $post->cover) && !empty($post->cover)) {
          unlink($coverFolderLocation . $post->cover);
        }

        // Если есть старое маленькое изображение - удаляем 
        if (file_exists($coverFolderLocation . $post->coverSmall) && !empty($post->coverSmall)) {
          unlink($coverFolderLocation . $post->coverSmall);
        }
          // Записываем имя файлов в БД
        $post->cover = $coverFileName[0];
        $post->coverSmall = $coverFileName[1];
      }
    }

    // Удаление обложки
    if ( isset($_POST['delete-cover']) && $_POST['delete-cover'] == 'on') {
      $coverFolderLocation = ROOT . 'usercontent/blog/';

      // Если есть старое изображение - удаляем 
      if (file_exists($coverFolderLocation . $post->cover) && !empty($post->cover)) {
        unlink($coverFolderLocation . $post->cover);
      }

      // Если есть старое маленькое изображение - удаляем 
      if (file_exists($coverFolderLocation . $post->coverSmall) && !empty($post->coverSmall)) {
        unlink($coverFolderLocation . $post->coverSmall);
      }

      // Удалить записи файла в БД
      $post->cover = NULL;
      $post->coverSmall = NULL;
    }

    R::store($post);

    if ( empty($_SESSION['errors'])) {
      $_SESSION['success'][] = ['title' => 'Пост успешно обновлен.'];
    }
  }
}

$post = R::load('posts', $_GET['id']);


// Центральный шаблон для модуля
ob_start();
include ROOT . "admin/templates/blog/edit.tpl";
$content = ob_get_contents();
ob_end_clean();

//Шаблон страницы
include ROOT . "admin/templates/template.tpl";
