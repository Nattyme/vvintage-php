<?php
declare(strict_types=1);

namespace Vvintage\Models\Shared;

use Vvintage\Models\Cart\Cart;
use Vvintage\Models\Favorites\Favorites;

class AbstractUserProductList
{
  private array $items;

    public function __construct( array $items)
    {
        $this->items = $items;
    }


    public function getItems(): array
    {
        return $this->items;
    }

    public function addItem(int $productId): void
    {
      // Добавляем новый товар
      if (!isset($this->items[$productId])) {
          $this->items[$productId] = 1;
      }
    }

    public function removeItem(int $productId): void
    {
        // Удаляем товар из модели
        if (isset($this->items[$productId])) {
          unset($this->items[$productId]);
        } 
    }

    // public function isSessionStale($key): bool
    // {
    //     $session = json_decode($_SESSION[$key] ?? '[]', true);
    //     return $session !== $this->items;
    // }

}