<?php
namespace Vvintage\Models\Settings;

// Подключаем readbean
use RedBeanPHP\R;

class Settings {
  private static array $settings = [];

  // Загружаем данные в класс
  public static function load(array $settings): void 
  {
    self::$settings = $settings;
  }

  public static function get(string $key): ?string 
  {
    return self::$settings[$key] ?? null;
  }

  public static function all(): array
  {
    return self::$settings;
  }
}

