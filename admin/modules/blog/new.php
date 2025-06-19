<?php
// Подключаем readbean
use RedBeanPHP\R; 

$pageTitle = "Блог - создание новой записи";
$pageClass = "admin-page";

// Получаем категории блога
$cats = R::find('blogcategories', "ORDER BY id DESC");

if( isset($_POST['postSubmit']) ) {
  
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

  if ( empty($_SESSION['errors'])) {
    $post = R::dispense('posts');
    $post->title = $_POST['title'];
    $post->cat = 'Ароматы';
    // $post->cat = $_POST['cat'];
    $post->description = $_POST['description'];
    $post->content = $_POST['content'];
    $post->timestamp = time();
    $post->views = NULL;

    // Если передано изображение - уменьшаем, сохраняем, записываем в БД
    if ( isset($_FILES['cover']['name']) && $_FILES['cover']['tmp_name'] !== '') {
      //Если передано изображение - уменьшаем, сохраняем файлы в папку
      $coverFileName = saveUploadedImg('cover', [600, 300], 12, 'blog', [1110, 460], [290, 230]);

      // Если новое изображение успешно загружено 
      if ($coverFileName) {
        // Записываем имя файлов в БД
        $post->cover = $coverFileName[0];
        $post->coverSmall = $coverFileName[1];
      }
    }

    R::store($post);

    $_SESSION['success'][] = ['title' => 'Пост успешно добавлен'];
    header('Location: ' . HOST . 'admin/blog');
    exit();
  }
}

// Центральный шаблон для модуля. Передаем шаблон текущ стараницы и гланвый шаблон, название страницы и класс(елси есть)
renderTemplateUseBufer(
  'admin/templates/blog/new.tpl', 
  'admin/templates/template.tpl',
  [
    'title' => 'Блог - создание новой записи', 
    'class' => 'admin-page'
  ]
);
