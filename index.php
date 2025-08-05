<?php

// Автозагрузка файлов через composer
require_once __DIR__ . '/vendor/autoload.php';

// Используем нужные классы
use Vvintage\Config\Config;
use Vvintage\Database\Database;
use Vvintage\Routing\RouteData;
use Vvintage\Routing\Router;
use Vvintage\Models\Settings\Settings;
use Vvintage\Config\LanguageConfig;

// Старт сесии (хранение ошибок, уведомлений, данных пользователя)
session_start();

$_SESSION['errors'] = [];
$_SESSION['success'] = [];

// Смена языка через ?lang=...
if (isset($_GET['lang']) && LanguageConfig::isSupported($_GET['lang'])) {
    $_SESSION['locale'] = $_GET['lang'];
    // Чтобы параметр lang не оставался в URI и не мешал, сделаем редирект без параметра
    $url = strtok($_SERVER["REQUEST_URI"], '?'); // убирает все GET-параметры
    header("Location: $url");
    exit;
}


// Выбор языка
$currentLang = LanguageConfig::getCurrentLocale();

define('ROOT', Config::getRoot());
define('HOST', Config::getHost());


require_once ROOT . 'libs/functions.php'; // подключаем пользовательскте ф-ции

// Подключение перводчика
use Vvintage\Services\Translator\Translator;
$translator = new Translator($currentLang); // создаем объект переводчика доступен глобально
setTranslator($translator); // сохраняем его
// setTranslator()->getTranslator()->getCatalogue(); // устанавливаем переводчик


// dd($translator);
Database::connect(); // Подключение БД:
Settings::init(); // Загружаем и сохраняем настройки


// Получаем части URI и создаем переменные (например: /shop/product/1)
$uri = $_SERVER['REQUEST_URI'];
$uriModule = getModuleName();    // первая часть пути — модуль
$uriGet = getUriGet();           // вторая часть — подстраница/id
$uriGetParam = getUriGetParam(); // третья часть — параметр get

// Передаем данные маршрутизатору
$routeData = new RouteData($uri, $uriModule, $uriGet, $uriGetParam);
Router::route($routeData);
