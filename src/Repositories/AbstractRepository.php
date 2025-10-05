<?php
declare(strict_types=1);

namespace Vvintage\Repositories;

use RedBeanPHP\R;
use RedBeanPHP\OODBBean;

abstract class AbstractRepository
{
  // Методы тразакций

  // Открывает транзакцию 
  public function begin(): void
  {
    R::begin();
  }

  // Пожтверждает транзакцию
  public function commit(): void
  {
    R::commit();
  }

  // отменяет транзакцию
  public function rollback(): void
  {
    R::rollback();
  }

 
  // Методы тразакций




    protected function loadBean(string $table, int $id): ?OODBBean
    {
        return $id > 0 ? R::load($table, $id) : null;
    }

    protected function createBean(string $table): OODBBean
    {
        return R::dispense($table);
    }

    protected function saveBean(OODBBean $bean): int
    {
        return (int) R::store($bean);
    }

    protected function deleteBean(OODBBean $bean): void
    {
        R::trash($bean);
    }



    protected function findById(string $table, int $id): ?OODBBean
    {
        $bean = R::findOne($table, 'id = ?', [$id]);
        return $bean ?: null;
    }

    protected function findOneBy(string $table, string $sql, array $params): ?OODBBean
    {
        $bean = R::findOne($table, $sql, $params);
        return $bean ?: null;
    }

    protected function findAll(
      string $table,
      array $conditions = [],       // условия WHERE, например ['age > ?']
      array $params = [],           // параметры для условий
      ?string $orderBy = null,      // сортировка, например 'name ASC'
      ?int $limit = null,           // лимит, например 10
      ?int $offset = null,          // смещение для пагинации
      ?string $groupBy = null       // GROUP BY, например 'role'
      ): array 
    {
        $sqlParts = [];

        // WHERE
        if (!empty($conditions)) {
            $sqlParts[] = 'WHERE ' . implode(' AND ', $conditions);
        }
     
        // GROUP BY
        if ($groupBy) {
            $sqlParts[] = 'GROUP BY ' . $groupBy;
        }

        // ORDER BY
        if ($orderBy) {
            $sqlParts[] = 'ORDER BY ' . $orderBy;
        }

        // LIMIT + OFFSET
        if ($limit !== null) {
            $sqlParts[] = 'LIMIT ' . $limit;
            if ($offset !== null) {
                $sqlParts[] = 'OFFSET ' . $offset;
            }
        }

        $sql = implode(' ', $sqlParts);

        return R::findAll($table, $sql, $params);
    }





    protected function findByIds(string $table, array $ids): array
    {
        if (empty($ids)) {
            return [];
        }

        
        // Подготовим placeholders (?, ?, ?) и массив параметров
        $placeholders = R::genSlots($ids);
        $sql = "id IN ($placeholders) ORDER BY id DESC";

        return R::find($table, $sql, $ids);
    }


    protected function countAll(string $table, ?string $sql = null, array $params = []): int
    {
        $sql = $sql ?? '';

        return (int) R::count($table, $sql, $params);
    }

   
    protected function getAll(string $sql, array $params): array
    {
      return R::getAll($sql, $params);
    }

    
    /**
     * Выполняет SQL-запрос (INSERT/UPDATE/DELETE и т.п.).
     *
     * @param string $sql SQL-запрос с плейсхолдерами.
     * @param array $params Параметры для запроса.
     * @return int Количество затронутых строк.
     */
    protected function execute(string $sql, array $params = []): int
    {
        return R::exec($sql, $params);
    }

    /**
     * Возвращает одно значение из базы (одно поле, одну "ячейку").
     *
     * @param string $sql SQL-запрос с плейсхолдерами.
     * @param array $params Параметры для запроса.
     * @return mixed|null Значение ячейки или null, если ничего не найдено.
     */
    protected function getCellValue(string $sql, array $params = []): mixed
    {
        $value = R::getCell($sql, $params);
        return $value !== null ? $value : null;
    }

   


}
