<?php
  if (empty($_SESSION['errors'])) {
    session_destroy();
    setcookie(session_name(), '', time() - 60);

    header("Location: " . HOST);
  }
