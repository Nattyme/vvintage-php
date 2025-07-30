<?php
  // Подключаем readbean
  use RedBeanPHP\R; 
  
  // Задаем название страницы и класс
  $pageTitle = "Магазин - редактировние товара";
  $pageClass = "admin-page";

  // Подкатегории
  $subCats = R::find('categories', 'parent_id IS NOT NULL');
  
  $sqlQuery =  'SELECT 
                  p.id,
                  p.title,
                  p.price,
                  p.content,
                  p.article,
                  p.url,
                  p.category,
                  p.brand,
                  p.timestamp,
                  c.title as cat_title,
                  b.title as brand_title
              
                FROM `products` as p
                LEFT JOIN `categories` as c ON p.category = c.id
                LEFT JOIN `brands` as b ON p.brand = b.id
                WHERE p.id = ? LIMIT 1';
  $product = R::getRow($sqlQuery, [$_GET['id']]);

  // Загружаем объект категории
  $subCatBean = R::load('categories', $product['category']);
  $selectedSubCat =  $subCatBean->id;

  // Главный раздел
  $selectedMaiCat = $subCatBean->parent_id;

  // Получаем список брендов
  $brands = R::find('brands', 'ORDER BY title ASC');

  // Запрашиваем информацию по изображениям продукта
  $sqlImages = 'SELECT 
                  pi.filename_small,
                  pi.image_order
                FROM `productimages` pi
                WHERE product_id = ?
                ORDER BY image_order ASC';
  $productImages = R::getAll($sqlImages, [$product['id']]);

  if( isset($_POST['submit'])) {
    // Проверка токена
    if (!check_csrf($_POST['csrf'] ?? '')) {
      $_SESSION['errors'][] = ['error', 'Неверный токен безопасности'];
    }

    // Проверка на заполненность названия
    if( trim($_POST['title']) == '' ) {
      $_SESSION['errors'][] = ['title' => 'Введите название товара'];
    } 

    // Проверка на заполненность содержимого
    if( trim($_POST['price']) == '' ) {
      $_SESSION['errors'][] = ['title' => 'Введите стоимость товара'];
    } 

    // Проверка на заполненность содержимого
    if( trim($_POST['content']) == '' ) {
      $_SESSION['errors'][] = ['title' => 'Введите описание товара'];
    } 

    // Если нет ошибок
    if ( empty($_SESSION['errors'])) {
      $product = R::load('products', $_GET['id']);
      $product->title = $_POST['title'];
      $product->cat = $_POST['subCat'];
      $product->brand = $_POST['brand'];
      $product->price = $_POST['price'];
      $product->content = $_POST['content'];
      $product->editTime = time();

      // Если передано изображение - уменьшаем, сохраняем, записываем в БД
      if( isset($_FILES['cover']['name']) && $_FILES['cover']['tmp_name'] !== '') {
        //Если передано изображение - уменьшаем, сохраняем файлы в папку, получаем название файлов изображений
        $coverFileName = saveUploadedImgNoCrop('cover', [600, 300], 12, 'products', [540, 380], [290, 230]);

        // Если новое изображение успешно загружено 
        if ($coverFileName) {
          $coverFolderLocation = ROOT . 'usercontent/products/';
          // Если есть старое изображение - удаляем 
          if (file_exists($coverFolderLocation . $product->cover) && !empty($product->cover)) {
            unlink($coverFolderLocation . $product->cover);
          }

          // Если есть старое маленькое изображение - удаляем 
          if (file_exists($coverFolderLocation . $product->coverSmall) && !empty($product->coverSmall)) {
            unlink($coverFolderLocation . $product->coverSmall);
          }
            // Записываем имя файлов в БД
          $product->cover = $coverFileName[0];
          $product->coverSmall = $coverFileName[1];
        }
      }

      // Удаление обложки
      if ( isset($_POST['delete-cover']) && $_POST['delete-cover'] == 'on') {
        $coverFolderLocation = ROOT . 'usercontent/products/';

        // Если есть старое изображение - удаляем 
        if (file_exists($coverFolderLocation . $product->cover) && !empty($product->cover)) {
          unlink($coverFolderLocation . $product->cover);
        }

        // Если есть старое маленькое изображение - удаляем 
        if (file_exists($coverFolderLocation . $product->coverSmall) && !empty($product->coverSmall)) {
          unlink($coverFolderLocation . $product->coverSmall);
        }

        // Удалить записи файла в БД
        $product->cover = NULL;
        $product->coverSmall = NULL;
      }

      R::store($product);

      if ( empty($_SESSION['errors'])) {
        $_SESSION['success'][] = ['title' => 'Товар успешно обновлен.'];
      }
    }
  }

  // Получаем продукт по id
  $product = R::load('products', $_GET['id']);

  // Центральный шаблон для модуля
  ob_start();
  include ROOT . "admin/templates/shop/edit.tpl";
  $content = ob_get_contents();
  ob_end_clean();

  //Шаблон страницы
  include ROOT . "admin/templates/template.tpl";
