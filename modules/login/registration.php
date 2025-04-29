<?php
$pageTitle = "Регистрация";
$pageClass = "authorization-page";
    
// Если форма отправлена - делаем регистрацию
if ( isset($_POST['register']) ) {
  //Проверка на заполненность
  if( trim($_POST['email']) == "" ) {
    // Ошибка - email пуст. Добавляем массив этой ошибки в массив $errors 
    $_SESSION['errors'][] = ['title' => 'Введите email', 'desc' => '<p>Email обязателен для регистрации на сайте</p>'];
  } else if ( !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ) {
    $_SESSION['errors'][] = ['title' => 'Введите корректный Email'];
  } else if ( trim($_POST['email']) ) {
    $result = true;
    $blockedUsers  = R::findOne( 'blockedusers', ' email = ? ', [ $_POST['email'] ] );
    $result = $blockedUsers !== NULL ? true : false;
    
    if ($result) {
      $_SESSION['errors'][] = ['title' => 'Ошибка регистрации.'];
    }
  }

  if( trim($_POST['password']) == "") {
    // Ошибка - пароль пуст. Добавляем массив этой ошибки в массив $errors 
    $_SESSION['errors'][] = ['title' => 'Введите пароль', 'desc' => 'Пароль обязателен для регистрации на сайте'];
  }

  if( ! trim($_POST['password']) == "" && strlen(trim($_POST['password']) ) < 5) {
    $_SESSION['errors'][] = ['title' => 'Неверный формат пароля', 'desc' => '<p>Пароль должен быть больше четырёх символов</p>'];
  }

  // Проверка на занятый email
  if ( R::count('users', 'email = ?', array($_POST['email'])) > 0 ) {
    $_SESSION['errors'][] = [
      'title' => 'Пользователь с таким email уже существует', 
      'desc' => '<p>Используйте другой email адрес или воспользуйтесь <a href="'.HOST.'lost-password">восстановлением пароля.</a></p>'
    ];
  }

  //Если нет ошибок - Регистрируем пользователя
  if ( empty($_SESSION['errors']) ) {
    $user = R::dispense('users');
    
    // Создаем бин в таблице адресов доставки
    $userDelivery = R::dispense('address');

    $user->email = $_POST['email'];
    $user->role = 'user';
    // Сохраняем пароль в зашифрованном виде функцией password_hash
    $user->password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $result = R::store($user);

    // Сохраняем id пользователя в таблицу адресов доставки
    $userDelivery->user_id = $result;
    R::store($userDelivery);
    
    if ( is_int($result) ) {
      // Автологин пользователя после регистрации
      $_SESSION['logged_user'] = $user;
      $_SESSION['login'] = 1;
      $_SESSION['role'] = $user->role;
      $_SESSION['success'][] = ['title' => 'Регистрация завершена.', 'desc'=>'Заполните свой профиль для дальнейшего пользования сайтом'];
      header('Location: ' . HOST . 'profile-edit');
      exit();

    } else {
      $_SESSION['errors'][] = ['title' => 'Что-то пошло не так. Повторите действие заново.'];
    }
  }
}

//Сохраняем код ниже в буфер
ob_start();
include ROOT . 'templates/login/form-registration.tpl';
//Записываем вывод из буфера в пепеменную
$content = ob_get_contents();
//Окончание буфера, очищаем вывод
ob_end_clean();

include ROOT . "templates/_page-parts/_head.tpl";
include ROOT . "templates/login/login-page.tpl";
include ROOT . "templates/_page-parts/_foot.tpl";



