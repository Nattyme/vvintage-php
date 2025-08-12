<?php
declare(strict_types=1);

namespace Vvintage\Repositories;

use RedBeanPHP\R;
use RedBeanPHP\OODBBean;

abstract class AbstractRepository
{
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


    /**
     * @param string $table Название таблицы
     * @param string|null $sql Дополнительные условия (например, WHERE, ORDER BY и т.д.)
     * @param array $params Параметры для SQL-запроса
     * @return OODBBean[]
     */
    protected function findAll(string $table, ?string $sql = null, array $params = []): array
    {
        if ($sql === null) {
            $sql = 'ORDER BY id ASC';
        } elseif (!preg_match('/^\s*(WHERE|ORDER BY)/i', $sql)) {
            $sql = 'WHERE ' . $sql;
        }
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


}
