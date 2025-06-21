<?php
require_once __DIR__ . '/vendor/autoload.php';

use Vvintage\Config\Config;
use Vvintage\Database\Database;
use Vvintage\Routing\RouteData;
use Vvintage\Routing\Router;
use Vvintage\Models\Settings\Settings;

// Старт сесии
session_start();

$_SESSION['errors'] = array();
$_SESSION['success'] = array();

define('ROOT', Config::getRoot());
define('HOST', Config::getHost());


Database::connect(); // Подключение БД:
Settings::init(); // Получение массива настроек

require_once ROOT . 'libs/functions.php';

// Задаем переменные
$uriModule = getModuleName();
$uriGet = getUriGet();
$uriGetParam = getUriGetParam();

$routeData = new RouteData($uriModule, $uriGet, $uriGetParam);
Router::route($routeData);

// require ROOT . 'modules/settings/settings.php';
// require ROOT . 'modules/admin-panel/admin-panel.php';
// require ROOT . 'modules/navigation/navigation.php';
// require ROOT . 'modules/cart/usercart.php';
// require ROOT . 'modules/shop/get-nav-categories.php';
// require ROOT . 'modules/favorite/userfavorite.php';




