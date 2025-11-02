<?php
declare(strict_types=1);

namespace Vvintage\Container;


class Container {
  private array $dependencies = [];

  public function set($name, $callback) {
    $this->$name = $callback();
  }
}