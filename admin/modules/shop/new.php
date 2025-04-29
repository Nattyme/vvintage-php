<?php
 
// Находим категории, относящиеся к секции shop
$cats = R::find('categories', 'ORDER BY title ASC');

// Получаем бренды
$brands = R::find('brands', 'ORDER BY title ASC'); 

if( isset($_POST['submit']) ) {
  // Проверка на заполненность названия
  if( trim($_POST['title']) == '' ) {
    $_SESSION['errors'][] = ['title' => 'Введите название товара'];
  } 

  if( trim($_POST['price']) == '' ) {
    $_SESSION['errors'][] = ['title' => 'Введите стоимость товара'];
  } 

  // Проверка на заполненность содержимого
  if( trim($_POST['content']) == '' ) {
    $_SESSION['errors'][] = ['title' => 'Введите описание товара'];
  } 

  if ( empty($_SESSION['errors']) ) {
    $product = R::dispense('products');
    $product->title = $_POST['title'];
    $product->brand = $_POST['brand'];
    $product->price = $_POST['price'];
    $product->content = $_POST['content'];
    $product->cat = $_POST['cat'];
    $product->timestamp = time();

    // Если передано изображение - уменьшаем, сохраняем, записываем в БД
    if ( isset($_FILES['cover']['name']) && $_FILES['cover']['tmp_name'] !== '') {

      //Если передано изображение - уменьшаем, сохраняем файлы в папку
      $coverSlidesName = saveSliderImg('cover', [350, 478], 12, 'products', [536, 566], [350, 478]);
      
      if ( empty($_SESSION['errors']) ) {
        R::store($product);
         // Если новое изображение успешно загружено 
        
        if ($coverSlidesName) {
         
          // Записываем имя файлов в БД
          foreach ( $coverSlidesName as $key => $value) {
            $productSliderImg = R::dispense('sliders');
            $productSliderImg->product_id = $product['id'];
        
            $cover_full = $coverSlidesName[$key][0];
            $cover = $coverSlidesName[$key][1];
            $cover_small = $coverSlidesName[$key][2];
            $productSliderImg->cover = $cover;
            $productSliderImg->cover_small = $cover_small;
            $productSliderImg->cover_full = $cover_full;
            R::store( $productSliderImg);
          }
        } 
        
        $_SESSION['success'][] = ['title' => 'Товар успешно добавлен'];
        header('Location: ' . HOST . 'admin/shop');
        exit();
      }

    }

    R::store($product);
    
    
    $_SESSION['success'][] = ['title' => 'Товар успешно добавлен'];
    header('Location: ' . HOST . 'admin/shop');
    exit();
  }
}

$pageTitle = "Магазин - добавить новый товар";
$pageClass = "admin-page";
// Центральный шаблон для модуля
ob_start();
include ROOT . "admin/templates/shop/new.tpl";
$content = ob_get_contents();
ob_end_clean();

//Шаблон страницы
include ROOT . "admin/templates/template.tpl";
