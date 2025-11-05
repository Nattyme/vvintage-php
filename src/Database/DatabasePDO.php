<?php

declare(strict_types=1);

namespace Vvintage\Database;

use Vvintage\Config\Config;

/**
 * Класс Database управляет подключением к БД и получением данных
 */
abstract class DatabasePDO
{
  private static $username = Config::DB_USER;
  private static $password = Config::DB_PASS;
  private static $dsn = 'mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME . ';charset=utf8';
  public static $affected_rows;

  public static function connect() 
  {
    try {
      // connection string, username, password
      $pdo = new \PDO(self::$dsn, self::$username, self::$password);
      // Throw errors as exceptions
      $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
      echo 'Connection successful';
    } 
    catch (\Exception $error) {
      error_log(  
          date('Y-m-d H:i:s') . "Danabase connection error:" . $error->getMessage(),
          3,
          'errors.log'
      );
      throw new \Exception('Database connection failed');
      return $pdo;
    }
  }

}
