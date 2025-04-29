<?php 
require "./../resize.php";
 //Если передано изображение - уменьшаем, сохр., записываем в БД
if( isset($_FILES['upload']['name']) && $_FILES['upload']['tmp_name'] !== '') {
  // 1. Записываем парам файла в переменные
  $fileName = $_FILES['upload']['name'];
  $fileTmpLoc = $_FILES['upload']['tmp_name'];
  $fileType = $_FILES['upload']['type'];
  $fileSize = $_FILES['upload']['size'];
  $fileErrorMsg = $_FILES['upload']['error'];
  $kaboom = explode(".", $fileName);
  $fileExt = end($kaboom);

  // 2. Проверка файла на соответствие требованиям сайта к фото
  // 2.1 Проверка на маленький размер изображения
  list($width, $height) = getimagesize($fileTmpLoc);
  if ($width < 1 || $height < 1 ) {
    $message = 'Изображение слишком маленького размера';
  }
  // 2.2 Проверка на большой вес файла изображения
  if ($fileSize > 12583912) {
    $message = 'Файл изображения не должен быть более 12 Mb';
  }

  // 2.3 Проверка на формат файла
  if (!preg_match("/\.(gif|jpg|jpeg|png)$/i", $fileName)) {
    $message = 'Файл изображения должен быть в формате gif, jpg, jpeg или png.';
  }

  // 2.4 Проверка на иную ошибку
  if ($fileErrorMsg == 1) {
    $message = 'При загрузке файла произошла ошибка. Повторите попытку.';
  }

  // Если ошибок нет
  if ( empty($_SESSION['errors']) ) {
    // Прописываем путь для хранения изображения
    $coverFolderLocation = ROOT . 'usercontent/editor-uploads/';

    $db_file_name = rand(100000000000,999999999999) . "." . $fileExt;
    $uploadfile = $coverFolderLocation . $db_file_name;

    // Проверем, если высота илиширина больше 920px, масштабируем изображение
    if ( $width > 920 || $height > 920) {
      // Масштабируем изображение
      $result = resize($fileTmpLoc, $uploadfile, 920);

      if ($result != true) {
        $message = 'Ошибка сохранения файла при масштабировании.';
        return false;
      }
    } else {
      $result = move_uploaded_file($fileTmpLoc, $uploadfile);

      if ($result != true) {
        $message = 'Ошибка перемещения файла.';
        return false;
      }
    }

    // Сохраняем имя файла в БД
    $url = HOST . "usercontent/editor-uploads/" . $db_file_name;
    $message = 'Файл успешно загружен';
  }
}

