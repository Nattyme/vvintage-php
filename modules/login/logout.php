<?php
  // Проверка токена
  if (!check_csrf($_POST['csrf'] ?? '')) {
    $_SESSION['errors'][] = ['error', 'Неверный токен безопасности'];
  }

  if (empty($_SESSION['errors'])) {
    session_destroy();
    setcookie(session_name(), '', time() - 60);

    header("Location: " . HOST);
  }
