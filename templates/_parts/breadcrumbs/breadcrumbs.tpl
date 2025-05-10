<?php

$breadcrumbs = [
  ['title' => 'Магазин', 'url' => HOST . 'shop'],
];


if (isset($category)) {
  $breadcrumbs[] = ['title' => $category['title'], 'url' => HOST . 'shop/' . $category['id']];
}

if (isset($product)) {
  $breadcrumbs[] = ['title' => $product['title'], 'url' => '#'];
}

echo getBreadcrumbs($breadcrumbs);

