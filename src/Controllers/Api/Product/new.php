<?php
  require_once './../../../config.php';
  require_once './../../../db.php';
  require_once ROOT . "libs/resize-and-crop.php";
  require_once ROOT . "libs/functions.php";
  
  header('Content-Type: application/json');

  $response = [];

  // Проверка на заполненность названия
  if ( trim($_POST['title']) == '' ) {
    $response['errors'][] = 'название товара';
  } 

  if( trim($_POST['price']) == '' ) {
    $response['errors'][] = 'стоимость товара';
  } 

  // // Проверка на заполненность ссылки
  if( trim($_POST['url']) == '' ) {
    $response['errors'][] = 'ссылка на vinted.fr';
  } 

  // Проверка на заполненность содержимого
  if( trim($_POST['content']) == '' ) {
    $response['errors'][] = 'описание товара';
  } 

  // // Если есть ошибки - сразу возвращаем 
  if (!empty($response['errors'])) {
    echo json_encode($response);

    // Очищаем ошибки, чтобы не дублировать
    unset($_SESSION['errors']);
    exit();
  }
  
  // Если передано изображение - уменьшаем, сохраняем, записываем в БД
  if ( isset($_FILES['cover']['name']) && $_FILES['cover']['tmp_name'] !== '') {
    //Если передано изображение - уменьшаем, сохраняем файлы в папку
    $coverImages = saveSliderImg('cover', [350, 478], 12, 'products', [536, 566], [350, 478]);

    // Если в сесси появились ошибки - добавляем их в ответ
    if (!empty($_SESSION['errors'])) {
      foreach($_SESSION['errors'] as $error) {
        $response['errorsImg'][] = [
          'title' => $error['title'],
          'url' => $error['fileName']
        ];
      }

      echo json_encode($response);
      // Очищаем ошибки, чтобы не дублировать
      unset($_SESSION['errors']);
      exit();
    }

    // Если массив изображений пуст - выводим ошибку
    if (empty($coverImages)) {
      $response['errors'][] = 'Добавьте изображения товара';
      echo json_encode($response);
      exit();
    }

     
    // Если новое изображение успешно загружено 
    $product = R::dispense('products');
    $product->title = $_POST['title'];
    $product->content = $_POST['content'];
    $product->price = $_POST['price'];
    $product->article = $_POST['article'];
    $product->category = $_POST['subCat'];
    $product->brand = $_POST['brand'];
    $product->stock = 1;
    $product->url = $_POST['url'];
    $product->timestamp = time();
    $product_id = R::store($product);
  
    // Записываем имя файлов в БД
    foreach ( $coverImages as $value) {
      $productImages = R::dispense('productimages');
      $productImages->product_id = $product_id;
  
      $productImages->filename_full = $value['cover_full'];
      $productImages->filename = $value['cover'];
      $productImages->filename_small = $value['cover_small'];
      $productImages->image_order = $value['order'];
      
      R::store( $productImages);
    }
    
   
    $response['success'][] = 'Товар успешно добавлен';
    unset($_SESSION['success']);
    $_SESSION['success'][] = ['title' => 'Товар успешно добавлен'];
    echo json_encode($response);
    exit();
  } else {
    $response['errors'][] = 'Добавьте изображения товара';
    echo json_encode($response);
    exit();
  }

 
    
    
    
