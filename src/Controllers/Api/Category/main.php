<?php
require_once './../../../config.php';
require_once './../../../db.php';
header('Content-Type: application/json');

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
