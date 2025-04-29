<?php
  if ( isset($_SESSION['login']) && $_SESSION['login'] === 1) {
    // Если админ
    if ($_SESSION['logged_user']['role'] === 'admin') { 
      echo "<a class=\"button-solid\" href=\"" . HOST . "profile-edit/". $user->id ."\">Редактировать</a>";
    }
    // Если юзер
    else if ($_SESSION['logged_user']['role'] === 'user') {
      // Открыл свой профиль
      if ( $_SESSION['logged_user']['id'] === $user->id ) {
        echo "<a class=\"button-solid\" href=\"" . HOST . "profile-edit\">Редактировать</a>";
      }
      // Открыл чужой профиль
    }
  } 
