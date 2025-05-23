<?php
require_once './../../../config.php';
require_once './../../../db.php';
header('Content-Type: application/json');

$response = [];

// Получаем бренды
$dataDB = R::find('brands', 'ORDER BY title ASC'); 

foreach ($dataDB as $data) {
  $response[] = [
    'id' => $data->id,
    'title' => $data->title
  ];
}

echo json_encode($response);
