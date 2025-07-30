<?php
  // Подключаем readbean
  use RedBeanPHP\R; 
  
  // Задаем название страницы и класс
  $pageTitle = "Магазин - удалить товар";
  $pageClass = "admin-page";
  $product = R::load('products', $_GET['id']); 

  if( isset($_POST['submit']) ) {
    // Проверка токена
    if (!check_csrf($_POST['csrf'] ?? '')) {
      $_SESSION['errors'][] = ['error', 'Неверный токен безопасности'];
    }


    if ( empty($_SESSION['errors'])) {
      // Удаление обложки
      if ( !empty($product['cover']) ) {
        // Удадить файлы обложки с сервера
        $coverFolderLocation = ROOT . 'usercontent/products/';
        unlink($coverFolderLocation . $product->cover);
        unlink($coverFolderLocation . $product->coverSmall);
      }

      // Удалить товар из корзины пользователей
      $users = R::find('users'); 
        foreach ($users as $user) {
          // Находим корзину пользователя в БД
          if ( !empty($user['cart'])) {
            $cart = json_decode($user->cart, true);
            
            if (array_key_exists($_GET['id'], $cart)) {
              unset($cart[$_GET['id']]); 

              // Обновляем корзину в сессии
              $_SESSION['cart'] = $cart;

              // Сохраняемм корзину в БД в JSON
              $user->cart = json_encode($cart);
              
              R::store($user);      
            }
            
          }
        }
        R::trash($product);

        $_SESSION['success'][] = ['title' => 'Товар был успешно удалён.'];
        header('Location: ' . HOST . 'admin/shop');
        exit();
      }

    }

  // Центральный шаблон для модуля
  ob_start();
  include ROOT . "admin/templates/shop/delete.tpl";
  $content = ob_get_contents();
  ob_end_clean();

  //Шаблон страницы
  include ROOT . "admin/templates/template.tpl";
