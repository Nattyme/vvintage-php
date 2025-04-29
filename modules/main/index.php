<?php
require_once ROOT . './libs/functions.php';
$uriModule = getModuleName();

$pageTitle = 'Womazing';

include ROOT . "templates/_page-parts/_head.tpl";

if(isset($_SESSION['logged_user']) && trim($_SESSION['logged_user']) !== '') {
  include ROOT . "templates/_parts/_admin-panel.tpl";
} 
include ROOT . "templates/_parts/_header.tpl";
include ROOT . "templates/main/main.tpl";
include ROOT . "templates/_parts/_footer.tpl";
include ROOT . "templates/_page-parts/_foot.tpl";