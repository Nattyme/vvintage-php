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


    protected function findAll(string $table, ?string $sql = null, array $params = []): array
    {
        // Если $sql пустой, просто выбираем все записи
        if (empty($sql)) {
            $sql = '';
        }

        // Если есть условия и они не начинаются с WHERE, добавляем WHERE
        if ($sql && !preg_match('/^\s*WHERE/i', $sql)) {
            $sql = 'WHERE ' . $sql;
        }



        // вызываем RedBeanPHP
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
