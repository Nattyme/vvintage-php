<?php 
require ROOT . "libs/rb-mysql.php";
R::setup('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);

// Замораживаем структуру — запрет на создание/изменение таблиц
R::freeze(true);
// R::useJSONFeatuews(TRUE);  // Настройка ReadBean, кот. сохраняет массив в БД в JSON формате