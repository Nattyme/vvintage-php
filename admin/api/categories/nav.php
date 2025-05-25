<?php
require_once './../../../config.php';
require_once './../../../db.php';
require_once ROOT . 'libs/functions.php';

header('Content-Type: application/json');

$response = [];

// Находим категории
$categoriesDB = R::findAll('categories');

foreach ($categoriesDB as $cat) {
  $response[] = [
    'id' => $cat->id,
    'name' => $cat->title, 
    'parentId' => $cat->parent_id
  ];
}

echo json_encode($response);