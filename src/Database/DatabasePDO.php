<?php

declare(strict_types=1);

namespace Vvintage\Database;

use Vvintage\Config\Config;

/**
 * Класс Database управляет подключением к БД и получением данных
 */
abstract class DatabasePDO
{
  private ?\PDO $pdo = null;
  private  $username = Config::DB_USER;
  private  $password = Config::DB_PASS;
  private  $dsn = 'mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME . ';charset=utf8';
  public  $affected_rows;

  public  function connect() 
  {
    try {
      if($this->pdo !== null) return $this->pdo;
      
      // connection string, username, password
      $this->pdo = new \PDO(
        $this->dsn, 
        $this->username, 
        $this->password
      );

      // Throw errors as exceptions
      $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
      echo 'Connection successful';
      return $this->pdo;
    } 
    catch (\Exception $error) {
      error_log(  
             date('Y-m-d H:i:s - ') . "База данных - ошибка соединения: " . $error->getMessage(),
          3,
          ROOT .'errors.log'
      );
      throw new \Exception('Ошибка соединения с базой данных');
      
    }
  }

  public function query($sql, $bindings_values = []) 
  {
    try {
      $pdo = $this->connect();
      $stmt = $pdo->prepare($sql);
      $stmt->execute($bindings_values);
      $this->affected_rows = $stmt->rowCount();

      // не обязательно, т.к. php автоматичесик закрывает соединение после завершения кода
      $stmt = null;
    }
    catch (\Exception $error) {
      error_log(  
             date('Y-m-d H:i:s - ') . "База данных - ошибка выполнения запроса: " . $error->getMessage(),
          3,
          ROOT .'errors.log'
      );
      throw new \Exception('Ошибка при выполнении запроса в базе данных');
      return $this->pdo;
    }
  }

  public function select($sql, $binding_values = []) 
  {
    try {
      $pdo = $this->connect();
      $stmt = $pdo->prepare($sql);
      $stmt->execute($binding_values);
      $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
      $stmt = null;
      return $data;
    }   
    catch (\Exception $error) {
      error_log(  
             date('Y-m-d H:i:s - ') . "База данных - ошибка при обработке запроса:  " . $error->getMessage(),
          3,
          ROOT .'errors.log'
      );
      throw new \Exception('Ошибка при обработке запроса из базы данных');
      return $this->pdo;
    }
  }

}
