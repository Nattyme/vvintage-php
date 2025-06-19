<?php
// Подключаем readbean
use RedBeanPHP\R;

$pageTitle = "Вход на сайт";
$pageClass = "authorization-page";

//1. Проверяем массив POST
if( isset($_POST['login']) ) {
  // Проверка токена
  if (!check_csrf($_POST['csrf'] ?? '')) {
    $_SESSION['errors'][] = ['error', 'Неверный токен безопасности'];
  }

  //2. Заполненность полей. Проверка на заполненность
  if( trim($_POST['email']) == '' ) {
    // Ошибка - email пуст. Добавляем массив этой ошибки в массив $errors 
    $_SESSION['errors'][] = ['title' => 'Введите email', 'desc' => '<p>Email обязателен для регистрации на сайте</p>'];
  } else if ( !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ) {
    $_SESSION['errors'][] = ['title' => 'Введите корректный Email'];
  } else if ( trim(strtolower($_POST['email'])) ) {
    $blockedUsers  = R::findOne( 'blockedusers', ' email = ? ', [ $_POST['email'] ] );
    $result = $blockedUsers !== NULL ? true : false;
    
    if ($result) {
      $_SESSION['errors'][] = ['title' => 'Ошибка, невозможно зайти в профиль.'];
    }
  }

  if( trim($_POST['password']) == "") {
    // Ошибка - пароль пуст. Добавляем массив этой ошибки в массив $errors 
    $_SESSION['errors'][] = ['title' => 'Введите пароль'];
  }

  // Если ошибок нет
  if( empty($_SESSION['errors']) ) {
    //3. Ищем нужного пользоваетля в базе данных
    $user = R::findOne('users', 'email = ?', array($_POST['email']));

    if ( $user ) {
      // Проверить пароль
      if( password_verify($_POST['password'], $user->password ) ) {
        // Пароль верен, вход на сайт 
        // Автологин пользователя после регистрации
        $_SESSION['logged_user'] = $user;
        $_SESSION['login'] = 1;
        $_SESSION['role'] = $user->role;
        
        $_SESSION['cart'] = json_decode($_SESSION['logged_user']['cart'], true);
        
        $_SESSION['fav_list'] = json_decode($_SESSION['logged_user']['fav_list'], true);
        // Работа с корзиной
        // Действия:
        // 1. Достать корзину из БД
        // 2. Совместить ее с COOKIES, если они есть
        // 3. Сохранить полученную корзину в БД
        // 4. Сохранить полученную корзину в сессию
        // 5. Очистить корзину COOKIE
        $temp_cart = array();
        $temp_fav_list = array();

        if ($user->cart) { $temp_cart = json_decode($user->cart, true); }
        if ($user->fav_list) { $temp_fav_list = json_decode($user->fav_list, true); }

        // Если есть корзина COOKIE, то переносим ее данные в БД $temp_cart 
        if ( isset($_COOKIE['cart']) && !empty($_COOKIE['cart']) ) {
          $cookie_cart = json_decode($_COOKIE['cart'], true);

          foreach ( $cookie_cart as $key => $value) {
            if ( isset($temp_cart[$key]) ) {
              $temp_cart[$key] += $value;
            } else {
              $temp_cart[$key] = $value;
            }
          }
        }

        // Если есть избранное в  COOKIE, то переносим эти данные в БД $temp_fav_list 
        if ( isset($_COOKIE['fav_list']) && !empty($_COOKIE['fav_list']) ) {
          $cookie_fav_list = json_decode($_COOKIE['fav_list'], true);

          foreach ( $cookie_fav_list as $key => $value) {
            if ( isset($temp_fav_list[$key]) ) {
              $temp_fav_list[$key] += $value;
            } else {
              $temp_fav_list[$key] = $value;
            }
          }
        }

        // Очищаем корзину в COOKIE
        setcookie('fav_list', '', time() - 3600);

        // Сохраняем корзину в БД - JSON
        $user->cart = json_encode($temp_cart);

        // Сохраняем избранное в БД - JSON
        $user->fav_list = json_encode($temp_fav_list);

        // Обновляем пользователя в БД
        R::store($user);

        // Обновляем корзину в сессии
        $_SESSION['cart'] = $temp_cart;

        // Обновляем избранное в сессии
        $_SESSION['fav_list'] = $temp_fav_list;
        if (isset($_SESSION['logged_user']['name']) && trim($_SESSION['logged_user']['name']) !== '') {
          $_SESSION['success'][] = ['title' => 'Здравствуйте, ' . htmlspecialchars($_SESSION['logged_user']['name']), 'desc' => 'Вы успешно вошли на сайт. Рады снова видеть вас'];
        } else {
          $_SESSION['success'][] = ['title' => 'Здравствуйте!', 'desc' => 'Вы успешно вошли на сайт. Рады снова видеть вас'];
        }
        
        header('Location: ' . HOST . 'profile');
        exit();
      } else {
        // Пароль не верен
        $_SESSION['errors'][] = ['title' => 'Неверный пароль'];
      }
    } else {
      // Email не найден
      $_SESSION['errors'][] = ['title' => 'Неверный email'];
    }
  }
}

//Сохраняем код ниже в буфер
ob_start();
include ROOT . 'templates/login/form-login.tpl';
//Записываем вывод из буфера в пепеменную
$content = ob_get_contents();
//Окончание буфера, очищаем вывод
ob_end_clean();

include ROOT . "templates/_page-parts/_head.tpl";
include ROOT . "templates/login/login-page.tpl";
include ROOT . "templates/_page-parts/_foot.tpl";