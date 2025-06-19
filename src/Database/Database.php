<?php 
namespace Vvintage\Database;

use RedBeanPHP\R;
use Vvintage\Config\Config;

class Database {
  public static function connect():void {
    R::setup(
      'mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME,
      Config::DB_USER,
      Config::DB_PASS
    );
    // можно включить JSON-фичи, если нужно
    // R::useJSONFeatures(true);
  }
}

// R::useJSONFeatuews(TRUE);  // Настройка ReadBean, кот. сохраняет массив в БД в JSON формате