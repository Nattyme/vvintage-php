<?php

declare(strict_types=1);

namespace Vvintage\Models\Settings;

use Vvintage\Database\Database;

/**
 * Класс Settings управляет массивом настроек, загруженных из БД
 */
final class Settings
{
    private static array $settings = [];

    /**
     * Загружаем массив настроек в св-во
     *
     * @param array<string, string> $settings
    */
    public static function load(array $settings): void
    {
        self::$settings = $settings;
    }

    // Инициализация: получаем и загружаем настройки из БД
    public static function init(): void
    {
      $settings = Database::getSettingsArray();
      self::load($settings);
    }


    /**
     * Получаем знач-е настройки по ключу
     *
     * @param string $key Ключ настройка
     * @return string|null Значение или null, если ключ не найден
     */
    public static function get(string $key): ?string
    {
      return self::$settings[$key] ?? null;
    }


    /**
     * Возвращает все настройки
     *
     * @return array<string, string>
     */
    public static function all(): array
    {
        return self::$settings;
    }
}
