<?php

// DB SETTINGS
define('DB_HOST', 'localhost');
define('DB_NAME', 'vvintage');
define('DB_USER', 'root');
define('DB_PASS', '');

// Yookassa settings
// define('SHOP_ID', '456967');
// define('SECRET_KEY', 'test_NhEQAfcEMhED_WHSeUKrBwfKUtSAOknwYgf-TbSTho4');

if( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
  $protocol = 'https://';
} else {
  $protocol = 'http://';
}
// Хост сайта - используется для ссылок в браузере < href="..">
define('HOST', $protocol . $_SERVER['HTTP_HOST'] . '/'); //  //project/

//Физический путь к корневой директории скрипта
define('ROOT', dirname(__FILE__) . '/');

// Для внешних ссылок
define('OUTLINK', $protocol);

// Доп настройки
define('SITE_NAME', 'vvintage');
define('SITE_EMAIL', 'info@vvintage.com'); //email обяз-но домена, где расположен сайт, чтобы не поло в спам
