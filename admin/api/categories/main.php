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

// Находим главные категории
$dataDB = R::find('categories', 'parent_id IS NULL ORDER BY title ASC');

foreach ($dataDB as $data) {
  $response[] = [
    'id' => $data->id,
    'title' => $data->title
  ];
}

echo json_encode($response);
