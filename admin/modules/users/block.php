<?php
  // Подключаем readbean
  use RedBeanPHP\R; 

  // Если в GET передан ID, то пользователь зарегестрирован
  if(isset($_GET['id']) && !empty($_GET['id'])) {
    $user = R::load('users', $_GET['id']); 

    if( isset($_POST['block-user']) ) {
      $userBlocked = R::dispense('blockedusers');
      $userBlocked->email = $user['email'];
      $userBlocked->user_id = $user['id'];

      // Сохраняем пользователя в блок лист
      R::store($userBlocked);

      // Удаление обложки
      if ( !empty($user['avatar']) ) {
        // Удадить файлы обложки с сервера
        $avatarFolderLocation = ROOT . 'usercontent/avatars/';
        unlink($avatarFolderLocation . $user->avatar);
        unlink($avatarFolderLocation . $user->avatarSmall);
      }
  
      // Находим все комментарии пользователя в таблице комментариев
      $commentsToDelete = R::find('comments', ' user LIKE ?', [$userBlocked['user_id']]);

      // Если есть комментарии - обходим массив комментариев и удаляем 
      if ($commentsToDelete) {
        foreach ($commentsToDelete as $comment) {
          R::trash($comment);
        }
      }

      // Находим все сообщения пользователя в таблице сообщений
      $messagesToDelete = R::find('messages', ' user_id LIKE ?', [$userBlocked['user_id']]);
      
      // Если есть сообщния - обходим массив сообщений и удаляем 
      if ( $messagesToDelete ) {
        foreach ($messagesToDelete as $message) {
          R::trash($message);
        }
      }

      R::trash($user);

      $_SESSION['success'][] = ['title' => 'Пользователь заблокирован. Все его комментарии и сообщения успешно удалены. '];
      header('Location: ' . HOST . 'admin/users');
      exit();
    }
  }

  // Если в GET передан email, то пользователь не зарегестрирован
  if(isset($_GET['email']) && !empty($_GET['email'])) {
    if( isset($_POST['block-user']) ) {
      $userBlocked = R::dispense('blockedusers');
      $userBlocked->email = $_GET['email'];
      $userBlocked->user_id = NULL;

      // Сохраняем пользователя в блок лист
      R::store($userBlocked);

      // Находим все сообщения пользователя в таблице сообщений
      $messagesToDelete = R::find('messages', ' email LIKE ?', [$userBlocked['email']]);
      
      // Если есть сообщния - обходим массив сообщений и удаляем 
      if ( $messagesToDelete ) {
        foreach ($messagesToDelete as $message) {
          R::trash($message);
        }
      }

      $_SESSION['success'][] = ['title' => 'Пользователь заблокирован. Все его сообщения успешно удалены. '];
      header('Location: ' . HOST . 'admin/messages');
      exit();
    }
  }

  $pageTitle = "Блог - заблокировать пользователя";
  $pageClass = "admin-page";
  // Центральный шаблон для модуля
  ob_start();
  include ROOT . "admin/templates/users/block.tpl";
  $content = ob_get_contents();
  ob_end_clean();

  //Шаблон страницы
  include ROOT . "admin/templates/template.tpl";
