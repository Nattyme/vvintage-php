<?php
require_once './../../../config.php';
require_once './../../../db.php';
header('Content-Type: application/json');
// ini_set('display_errors', 1);
// error_reporting(E_ALL);
// Проверка прав (можно по сессии)
// if (!(isset($_SESSION['role']) && $_SESSION['role'] === 'admin')) {
//     echo json_encode(['error' => 'Нет доступа']);
//     exit;
// }
$response = [];

// Находим категории, относящиеся к секции shop
$catsRows = R::find('categories', 'parent_id IS NULL ORDER BY title ASC');

foreach ($catsRows as $cat) {
  $response[] = [
    'id' => $cat->id,
    'title' => $cat->title
  ];
}

echo json_encode($response);
