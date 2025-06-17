<?php
  const ALLOWED_COUNTER_TABLES = ['messages', 'orders', 'comments'];

  function getAdminCounter (string $tableName, string $status = 'new', int $limit=9) {
    if (!in_array($tableName, ALLOWED_COUNTER_TABLES, true)) {
      throw new InvalidArgumentException("Недопустимое имя таблицы: $tableName");
    }
    $counter = R::count($tableName, ' status = ?', [$status]);
    return [
      'counter' =>  $counter,
      'limit' => $limit
    ];
  }
