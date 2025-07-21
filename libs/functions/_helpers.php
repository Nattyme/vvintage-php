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

// Безопасное получение значения из $_GET с проверкой допустимых значений
// $lang = get('lang', ['ru', 'en', 'fr'], 'ru');
// $_SESSION['lang'] = $lang;
// function get(string $key, array $allowed = [], string $default = ''): string {
//   $value = $_GET[$key] ?? $default;
//   $value = trim(strip_tags($value));
//   $value = mb_substr($value, 0, 10); // ограничение длинны

//   if (!empty($allowed) && !in_array($value, $allowed)) {
//     return $default;
//   }
  

//   return $value;
// }
/**
 * Безопасно получает значение из $_GET с фильтрацией
 *
 * @param string $key — имя ключа в $_GET
 * @param string $type — тип значения: 'string', 'int', 'float', 'bool'
 * @param mixed $default — значение по умолчанию
 * @return mixed — отфильтрованное значение
 */
function get(string $key, string $type = 'string', $default = '')
{
    if (!isset($_GET[$key])) {
        return $default;
    }

    $value = $_GET[$key];

    switch ($type) {
        case 'int':
            $value = filter_var($value, FILTER_SANITIZE_NUMBER_INT);
            return is_numeric($value) ? (int)$value : $default;

        case 'float':
            $value = filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            return is_numeric($value) ? (float)$value : $default;

        case 'bool':
            return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? $default;

        case 'string':
        default:
            $value = trim(strip_tags($value));
            return mb_substr($value, 0, 255); // ограничим длину строки
    }
}

//Ф-ция проверяет метод отрпавки 
// isRequestMethod('post') 
function isRequestMethod(string $method): bool 
{
    return $_SERVER['REQUEST_METHOD'] === strtoupper($method);
}


