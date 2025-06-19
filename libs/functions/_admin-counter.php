<?php
  use RedBeanPHP\R;

  function getCounter (string $tableName, ?string $status = null, int $limit=9) : array {
    if (!R::inspect($tableName)) {
      throw new InvalidArgumentException("Таблица не существует: $tableName");
    }

    $counter = $status !== null
      ? R::count($tableName, ' status = ?', [$status])
      : R::count($tableName);

      return [
        'counter' => $counter,
        'limit' => $limit
      ];
  }

  const ALLOWED_COUNTER_TABLES = ['messages', 'orders', 'comments'];
  
  function getAdminCounter (string $tableName, string $status = 'new', int $limit=9) {

    if (!in_array($tableName, ALLOWED_COUNTER_TABLES, true)) {
      throw new InvalidArgumentException("Недопустимое имя таблицы: $tableName");
    }
    
    return getCounter($tableName, $status, $limit);
  }

  
