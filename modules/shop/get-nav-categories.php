<?php
require_once ROOT . 'config.php';
require_once ROOT . 'db.php';
require_once ROOT . 'libs/functions.php';

header('Content-Type: application/json');


$categories = R::findAll('categories');

$categoryArray = array_map(function ($cat) {
  return [
    'id' => $cat->id,
    'name' => $cat->title, 
    'parentId' => $cat->parent_id
  ];
}, $categories);

echo json_encode($categoryArray);