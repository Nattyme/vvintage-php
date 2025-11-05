<?php

// Автозагрузка файлов через composer
require_once __DIR__ . '/vendor/autoload.php';

// Используем нужные классы
use Vvintage\Config\Config;
use Vvintage\Database\Database;
use Vvintage\Database\DatabasePDO;
use Vvintage\Routing\RouteData;
use Vvintage\Routing\Router;
use Vvintage\Models\Settings\Settings;
use Vvintage\Config\LanguageConfig;
use Vvintage\Utils\Services\Locale\LocaleService;
use Vvintage\Public\Services\Translator\Translator;
use Vvintage\Utils\Services\Session\SessionService;

// Старт сесии (хранение ошибок, уведомлений, данных пользователя)
$sessionService = new SessionService();
$sessionService->startSession();


define('ROOT', Config::getRoot());
define('HOST', Config::getHost());
$pdo = DatabasePDO::connect();
require_once ROOT . 'libs/functions.php'; // подключаем пользовательскте ф-ции


// Обработка смены языка и редирект
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
setTranslator($translator);           // сохраняем объект глобально (в функции)

Database::connect(); // Подключение БД:
Settings::init(); // Загружаем и сохраняем настройки

// Создаём объект RouteData через parseUri()
$routeData = RouteData::parseUri();

if ($routeData->isAdmin) {
    Router::routeAdminPages($routeData);
} else {
    Router::route($routeData);
}
