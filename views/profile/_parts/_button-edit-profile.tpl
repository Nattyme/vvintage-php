<?php
  if ( isset($_SESSION['login']) && $_SESSION['login'] === 1) {
    // Если админ
    if ($_SESSION['logged_user']['role'] === 'admin') { 
      echo "<a class=\"button button--s button--primary\" href=\"" . HOST . "profile-edit/". $userModel->getId() ."\">Редактировать</a>";
    }
    // Если юзер
    else if ($_SESSION['logged_user']['role'] === 'user') {
      // Открыл свой профиль
      if ( $_SESSION['logged_user']['id'] === $userModel->getId() ) {
        echo "<a class=\"button button--s button--primary\" href=\"" . HOST . "profile-edit\">Редактировать</a>";
      }
      // Открыл чужой профиль
    }
  } 
