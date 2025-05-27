<?php 
print_r($_SESSION);
die();
  function getUserComments($userId) {
    $sqlQuery = 'SELECT
                        comments.id, comments.text, comments.post, comments.user, comments.timestamp, 
                        posts.title
                 FROM `comments`
                 LEFT JOIN `posts` ON comments.post = posts.id
                 WHERE comments.user = ?';
    return R::getAll($sqlQuery, [$userId]);
  }
  
  // Проверка есть ли в ссылке параметр с ID пользователя
  if ( isset($uriGet)) {
    // ID был передан. Находим пользоватея в БД. Загружаем данные пользователя из БД по его ID
    $user = R::load('users', $uriGet);
    
    // Загружаем комментарии пользователя
    $comments = getUserComments($uriGet);
  
  } else {
    // Дополнительного параметра не было. Проверка вошел пользователь или нет 
    if ( isset($_SESSION['login']) && $_SESSION['login'] === 1) {
      // Пользователь залогинен и показываем его профиль
      $user = R::load('users', $_SESSION['logged_user']['id']);

      // Заказы пользователя - только свои, только для залогиненных
      $orders = R::findLike('orders', ['user_id' => [$_SESSION['logged_user']['id']]], 'ORDER BY id DESC');

      // Загружаем комментарии пользователя
      $comments = getUserComments($_SESSION['logged_user']['id']);
    } else {
      // Пользователб не залогинен, показываем приглашение к регистрации 
      $userNotLoggedIn = true;
    }
  }

  $pageTitle = "Профиль пользователя";
  $pageClass = "profile-page";

  include ROOT . 'templates/_page-parts/_head.tpl';
  include ROOT . 'templates/_parts/_header.tpl';

  include ROOT . 'templates/profile/profile.tpl';
  
  include ROOT . 'templates/_parts/_footer.tpl';
  include ROOT . 'templates/_page-parts/_foot.tpl';