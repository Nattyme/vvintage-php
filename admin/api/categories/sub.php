<?php
require_once './../../../config.php';
require_once './../../../db.php';
header('Content-Type: application/json');

$response = [];

// Проверка: передан ли parent_id
if (!isset($_GET['parent_id']) || !is_numeric($_GET['parent_id'])) {
  http_response_code(400);
  echo json_encode(['error' => 'Некорректный parent_id']);
  exit;
}

$parentId = (int) $_GET['parent_id'];

// Получаем подкатегории по переданному id главное категории
$subCats = R::find('categories', 'parent_id = ? ORDER BY title ASC', [$parentId]);

foreach ($subCats as $cat) {
  $response[] = [
    'id' => $cat->id,
    'title' => $cat->title
  ];
}

echo json_encode($response);
