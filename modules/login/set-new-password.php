<?php
$pageTitle = "Установить новый пароль";
$pageClass = "authorization-page";

// 1. Пришли по секретной ссыке с email
if( !empty($_GET['email']) && !empty($_GET['code'])) {

  // 2. Найти пользователя по email в БД
  $user = R::findOne('users', 'email = ?', array($_GET['email'])); 

  if (!$user) {
    header("Location: " . HOST . "lost-password");
  } 
  
} else if ( !empty($_POST['set-new-password'])) {
  // Найти пользователя по email в БД
  $user = R::findOne('users', 'email = ?', array($_POST['email'])); 
  if( $user ) {
    // Проверить секретный код на верность
    if( $user->recovery_code === $_POST['resetCode'] && $user->recovery_code != '' && $user->recovery_code != null) {

      // Смена пароля. Сохраняем пароль в зашифрованном виде функцией password_hash
      $user->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
      $user->recovery_code = '';
      R::store($user);
    
      $_SESSION['success'][] = ['title' => 'Пароль был успешно изменён'];

      $newPasswordReady = true;
    } else {
      $_SESSION['errors'][] = ['title' => 'Неверный код'];
    }
  }
}

else {
  // Если не понятно как, но попал на страницу
  header("Location: " . HOST . "lost-password");
  die();
}

ob_start();
include ROOT . 'templates/login/set-new-password.tpl';
//Записываем вывод из буфера в пепеменную
$content = ob_get_contents();
//Окончание буфера, очищаем вывод
ob_end_clean();

include ROOT . "templates/_page-parts/_head.tpl";
include ROOT . "templates/login/login-page.tpl";
include ROOT . "templates/_page-parts/_foot.tpl";