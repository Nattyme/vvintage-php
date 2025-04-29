<?php
// Получаем  текущую секцию 
$currentSection = getCurrentSection ();
$_SESSION['currentSection'] = $currentSection;

// Находим категории, относящиеся к секции shop
$catsArray = R::find('categories', ' section LIKE ? ORDER BY title ASC', ['blog']);

// Создаем массив для категорий shop
$cats = [];
foreach ($catsArray as $key => $value) {
  $cats[] = ['id' => $value['id'], 'title' => $value['title'], 'section' => $value['section']];
}

if( isset($_POST['postSubmit']) ) {
  
  // Проверка на заполненность названия
  if( trim($_POST['title']) == '' ) {
    $_SESSION['errors'][] = ['title' => 'Введите заголовок поста'];
  } 

  // Проверка на заполненность содержимого
  if( trim($_POST['content']) == '' ) {
    $_SESSION['errors'][] = ['title' => 'Заполните содержимое поста'];
  } 

  if ( empty($_SESSION['errors'])) {
    $post = R::dispense('posts');
    $post->title = $_POST['title'];
    $post->cat = $_POST['cat'];
    $post->content = $_POST['content'];
    $post->timestamp = time();

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

$pageTitle = "Блог - создание новой записи";
$pageClass = "admin-page";
// Центральный шаблон для модуля
ob_start();
include ROOT . "admin/templates/blog/new.tpl";
$content = ob_get_contents();
ob_end_clean();

//Шаблон страницы
include ROOT . "admin/templates/template.tpl";
