<?php

// Автозагрузка файлов через composer
require_once __DIR__ . '/vendor/autoload.php';

// Используем нужные классы
use Vvintage\Config\Config;
use Vvintage\Database\Database;
use Vvintage\Routing\RouteData;
use Vvintage\Routing\Router;
use Vvintage\Models\Settings\Settings;

// Старт сесии (хранение ошибок, уведомлений, данных пользователя)
session_start();

$_SESSION['errors'] = [];
$_SESSION['success'] = [];

define('ROOT', Config::getRoot());
define('HOST', Config::getHost());


Database::connect(); // Подключение БД:
Settings::init(); // Загружаем и сохраняем настройки

require_once ROOT . 'libs/functions.php'; // подключаем пользовательскте ф-ции

// Получаем части URI и создаем переменные (например: /shop/product/1)
$uriModule = getModuleName();    // первая часть пути — модуль
$uriGet = getUriGet();           // вторая часть — подстраница/id
$uriGetParam = getUriGetParam(); // третья часть — параметр get

// Передаем данные маршрутизатору
$routeData = new RouteData($uriModule, $uriGet, $uriGetParam);
Router::route($routeData);
function helloWorld()
{
    echo 'Привет, Наташа';
}

// require ROOT . 'modules/settings/settings.php';
// require ROOT . 'modules/admin-panel/admin-panel.php';
// require ROOT . 'modules/navigation/navigation.php';
// require ROOT . 'modules/cart/usercart.php';
// require ROOT . 'modules/shop/get-nav-categories.php';
// require ROOT . 'modules/favorite/userfavorite.php';
