<?php
declare(strict_types=1);

namespace App\Container;

use Exception;

class Container
{
    // фабрики: id => callable($container) => object
    private array $factories = [];

    // кеш созданных экземпляров (singletons)
    private array $instances = [];

    // регистрируем "рецепт" создания сервиса
    public function set(string $id, callable $factory): void
    {
        $this->factories[$id] = $factory;
    }

    // получаем сервис
    public function get(string $id)
    {
        // Если уже создан — возвращаем (singleton)
        if (isset($this->instances[$id])) {
            return $this->instances[$id];
        }

        if (!isset($this->factories[$id])) {
            throw new Exception("Service {$id} not found");
        }

        // создаём объект через фабрику и сохраняем в кеш
        $this->instances[$id] = $this->factories[$id]($this);

        return $this->instances[$id];
    }
}
