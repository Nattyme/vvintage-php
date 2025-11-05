<?php

declare(strict_types=1);

namespace Vvintage\Database;

use RedBeanPHP\R;
use Vvintage\Config\Config;

/**
 * Класс Database управляет подключением к БД и получением данных
 */
final class Database
{
    /**
     * Подключение к БД иcпользуя ReadBean
     */
    public static function connect(): void
    {
        R::setup(
            'mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME,
            Config::DB_USER,
            Config::DB_PASS
        );
        // можно включить JSON-фичи, если нужно
        // R::useJSONFeatures(true); // Настройка ReadBean, кот. сохраняет массив в БД в JSON формате
    }


    /**
     * Получение массива настроек из таблицы settings
     *
     * @return array<string, string>
    */
    public static function getSettingsArray(): array
    {
        $settingsArray = R::find('settings', ' section LIKE ? ', ['settings']);
        $result = [];

        foreach ($settingsArray as $item) {
            $result[$item->name] = $item->value;
        }

        return $result;
    }

}
