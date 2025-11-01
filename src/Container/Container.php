<?php
declare(strict_types=1);

namespace Vvintage\Container;

// Класс контейнера - фабрика для создания других зависимостей 
class Container {
  private array $definition = [];

  public function set (string $id, callable $factory): void
  {
    $this->definition[$id] = $factory;
  }

  public function get(string $id)
  {
    if (!isset($this->definiton[$id]) ) {
      throw new \Exeption ("Сервис $id не найден в контейнере");
    }

    // Если объект уже был создан - возвращаем
    if (is_object($this->definitions[$id]) && !$this->definitions[$id] instanceof \Closure) {
      return $this->definitions[$id];
    }

    //Иначе создаем экземпляр и сохраняем 
    $this->definitions[$id] = $this->definitions[$id]($this);
    return $this->definitions[$id];

  }
}