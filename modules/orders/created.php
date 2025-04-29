<?php
require_once ROOT . './libs/functions.php';
$uriModule = getModuleName();

$pageTitle = 'Заказ оформлен';

include ROOT . "templates/_page-parts/_head.tpl";
include ROOT . "templates/_parts/_header.tpl";
include ROOT . "templates/orders/created.tpl";
include ROOT . "templates/_parts/_footer.tpl";
include ROOT . "templates/_page-parts/_foot.tpl";