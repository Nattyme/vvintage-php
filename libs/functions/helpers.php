<?php

// HTML-безопасный вывод (для шаблонов)
function h($string): string {
  return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// Для URL (Чтобы безопасно вставить данные в ссылку (query string).)
// $brand = 'Chanel & Dior';
// $url = '/admin/brands.php?search=' . u($brand);
// echo $url; // /admin/brands.php?search=Chanel+%26+Dior
function u($string): string {
  return urlencode($string);
}

// Форматирование даты
// echo formatDate('2025-05-26 13:30'); // 26.05.2025 13:30
function formatDate($date, $format = 'd.m.Y H:i'): string {
  return date($format, strtotime($date));
}

// Форматирование цены
// echo formatPrice(15990); // 15 990 ₽
function formatPrice($price): string {
  return number_format($price, 0, ',', ' ') . ' ₽';
}

// Обрезка текста
// echo shortText('Очень длинное описание товара, которое не влезет на карточку.', 30);
// Очень длинное описание това…
function shortText($text, $limit = 100): string {
  return mb_strlen($text) > $limit ? mb_substr($text, 0, $limit) . '…' : $text;
}

// Flash-сообщения (для админки)
// setFlash('success', 'Бренд успешно добавлен!');
// header('Location: all.php');
// exit;
function setFlash($key, $message) {
  $_SESSION['flash'][$key] = $message;
}

function getFlash($key) {
  if (isset($_SESSION['flash'][$key])) {
    $msg = $_SESSION['flash'][$key];
    unset($_SESSION['flash'][$key]);
    return $msg;
  }
  return null;
}

// CSRF-токен генерация токена для защиты форм.Защита от поддельных форм (CSRF-атак).
// <input type="hidden" name="csrf" value="<?php  csrf_token();>?">
function csrf_token(): string {
  if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
  }
  return $_SESSION['csrf'];
}

// Убедиться, что форму отправил сайт, а не злоумышленник.
//  <!-- CSRF-токен -->
  // <input type="hidden" name="csrf" value="<?= csrf_token() ?">
// if (!check_csrf($_POST['csrf'])) {
//   setFlash('error', 'Неверный токен безопасности');
//   header('Location: form.php');
//   exit;
// }
function check_csrf($token): bool {
  return isset($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $token);
}

// Вывод переменной (для отладки)
function dd($data): void {
  echo '<pre>';
  print_r($data);
  echo '</pre>';
  exit;
}

function dump($data): void {
  echo '<pre>';
  print_r($data);
  echo '</pre>';
}
