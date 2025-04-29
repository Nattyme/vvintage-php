<?php 
require ROOT . "libs/rb-mysql.php";
R::setup('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
// R::useJSONFeatuews(TRUE);  // Настройка ReadBean, кот. сохраняет массив в БД в JSON формате