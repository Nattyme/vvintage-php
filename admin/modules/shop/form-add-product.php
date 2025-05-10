<?php
  $response = [];

  // Проверка на заполненность названия
  if( trim($_POST['title']) == '' ) {
    $response['errors'][] = ['название товара'];
  } 

  if( trim($_POST['price']) == '' ) {
    $response['errors'][] = ['стоимость товара'];
  } 

  // Проверка на заполненность ссылки
  if( trim($_POST['outlink']) == '' ) {
    $response['errors'][] = ['заполинте ссылку на vinted.fr'];
  } 
  // Проверка на заполненность содержимого
  if( trim($_POST['content']) == '' ) {
    $response['errors'][] = ['описание товара'];
  } 

  
  // Если передано изображение - уменьшаем, сохраняем, записываем в БД
  if ( isset($_FILES['cover']['name']) && $_FILES['cover']['tmp_name'] !== '') {

    //Если передано изображение - уменьшаем, сохраняем файлы в папку
    $coverImages = saveSliderImg('cover', [350, 478], 12, 'products', [536, 566], [350, 478]);
    if (!$coverImages) $response['errors'][] = ['описание товара'];
    // Если новое изображение успешно загружено 
    $product = R::dispense('products');
    $product->title = $_POST['title'];
    $product->content = $_POST['content'];
    $product->price = $_POST['price'];
    $product->article = $_POST['article'];
    $product->category = $_POST['cat'];
    $product->brand = $_POST['brand'];
    $product->stock = 1;
    $product->url = $_POST['url'];
    $product->timestamp = time();

    R::store($product);

      // Записываем имя файлов в БД
      foreach ( $coverImages as $value) {
        $productImages = R::dispense('productimages');
        $productImages->product_id = $product['id'];
    
        $productImages->filename_full = $value['cover_full'];
        $productImages->filename = $value['cover'];
        $productImages->filename_small = $value['cover_small'];
        $productImages->image_order = $value['order'];
        
        R::store( $productImages);
      }
      
      $response['success'][] = ['Товар успешно добавлен'];
      echo json_encode($response);
      exit();
    } 

      
 
  if (!empty($response['errors'])) {
    echo json_encode($response);
    exit();
  }


    
    
    
