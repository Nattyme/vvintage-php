<?php
$pageTitle = "Восстановить пароль";
$pageClass = "authorization-page";

// 1. Проверить, что форма отправлена. Принять данные
if ( isset($_POST['lost-password']) ) {
  // Проверка токена
  if (!check_csrf($_POST['csrf'] ?? '')) {
    $_SESSION['errors'][] = ['error', 'Неверный токен безопасности'];
  }

  // 2. Проверка на заполненный email
  if( trim($_POST['email']) == '') {
    $_SESSION['errors'][] = ['title' => 'Введите email', 'desc' => '<p>Email - обязательное поле</p>'];
  } else if ( !filter_var( trim($_POST['email']), FILTER_VALIDATE_EMAIL) ) {
    $_SESSION['errors'][] = ['title' => 'Введите корректный Email'];
  }

  if ( empty($_SESSION['errors'])) {
    // 3. Проверить есть ли пользователь с такиv email в БД
    $user = R::findOne('users', 'email = ?', array( trim($_POST['email']) ));

    if ( $user ) {

      // 4. Генерируем секретный код
      function random_str($num = 30) {
        return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $num);
      }

      $recovery_code = random_str();
      // 5. Запомнить секретный код. Записать в БД.
      $user->recovery_code = $recovery_code;
      R::store($user);
 
      // 6. Присылаем пользователю спец ссылку с секретным кодом для сброса пароля
      $recovery_message  = "<p>Код сброса пароля: <strong>$recovery_code</strong></p>";
      $recovery_message .= "<p>Для сброса пароля перейдите по ссылке ниже и установите новый пароль:</p>";

      $recovery_link     = HOST . "set-new-password?email={$_POST['email']}&code={$recovery_code}";
      $recovery_message .= '<p> <a href="' . $recovery_link . '">Установить новый пароль</a> </p>';

      $headers =  "MIME-Version: 1.0" . PHP_EOL .
                  "Content-Type: text/html; charset=utf-8" . PHP_EOL .
                  "From: " . "=?utf-8?B?" . base64_encode(SITE_NAME) . "?=" . "<" . SITE_EMAIL . ">" . PHP_EOL .
                  "Reply-To: " . SITE_EMAIL . PHP_EOL;

      $resultEmail = mail($_POST['email'], 'Восстановление доступа', $recovery_message, $headers);

      if ($resultEmail) {
        $_SESSION['success'][] = [
          'title' => 'Проверьте почту', 
          'desc' => '<p>На указанную почту был отправлен email с ссылкой для сброса пароля.</p>'
        ];
        // $emailSent = true;
      } else {
        $_SESSION['errors'][] = [
          'title' => 'Что-то пошло не так. Повторите действие заново.', 
          'desc' => '<p>Произошла ошибка. Повторите отправку формы.</p>'
        ];
      }

    } else {
      // Email не найден
      $_SESSION['errors'][] = ['title' => 'Пользователя с таким email не существует'];
    }

  }

}

//Сохраняем код ниже в буфер
ob_start();
include ROOT . 'templates/login/lost-password.tpl';
//Записываем вывод из буфера в пепеменную
$content = ob_get_contents();
//Окончание буфера, очищаем вывод
ob_end_clean();

include ROOT . "templates/_page-parts/_head.tpl";
include ROOT . "templates/login/login-page.tpl";
include ROOT . "templates/_page-parts/_foot.tpl";