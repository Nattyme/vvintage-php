<?php
require_once ROOT . './libs/functions.php';
$uriModule = getModuleName();

$pageTitle = 'Оформление заказа';

include ROOT . "templates/_page-parts/_head.tpl";
include ROOT . "templates/_parts/_header.tpl";
include ROOT . "templates/orders/new.tpl";
include ROOT . "templates/_parts/_footer.tpl";
include ROOT . "templates/_page-parts/_foot.tpl";