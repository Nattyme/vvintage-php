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
use Vvintage\Services\Locale\LocaleService;
use Vvintage\Services\Translator\Translator;

// Старт сесии (хранение ошибок, уведомлений, данных пользователя)
session_start();

$_SESSION['errors'] = [];
$_SESSION['success'] = [];


define('ROOT', Config::getRoot());
define('HOST', Config::getHost());

require_once ROOT . 'libs/functions.php'; // подключаем пользовательскте ф-ции


// 1. Обработка смены языка и редирект
$localeService = new LocaleService();
if (isset($_GET['lang'])) {
  $localeService->setCurrentLang($_GET['lang']);
  
  $url = strtok($_SERVER["REQUEST_URI"], '?');
  header("Location: $url");
  exit;
}

$currentLang = $localeService->getCurrentLang(); 

// Подключение перводчика
$translator = new Translator($localeService->getCurrentLocale()); // создаем объект переводчика доступен глобально
// $translator->setLocale($currentLang); // вызываем метод setLocale()
setTranslator($translator);           // сохраняем объект глобально (в функции)

// setTranslator($translator); // сохраняем его
// setTranslator()->getTranslator()->getCatalogue(); // устанавливаем переводчик




// dd($translator);
Database::connect(); // Подключение БД:
Settings::init(); // Загружаем и сохраняем настройки

// Создаём объект RouteData через parseUri()
$routeData = RouteData::parseUri();

if ($routeData->isAdmin) {
    Router::routeAdminPages($routeData);
} else {
    Router::route($routeData);
}

// Получаем части URI и создаем переменные (например: /shop/product/1)
// $uri = $_SERVER['REQUEST_URI'];
// $uriModule = getModuleName();    // первая часть пути — модуль
// $uriGet = getUriGet();           // вторая часть — подстраница/id
// $uriGetParam = getUriGetParam(); // третья часть — параметр get

// Передаем данные маршрутизатору
// $routeData = new RouteData($uri, $uriModule, $uriGet, $uriGetParam);
// Router::route($routeData);
