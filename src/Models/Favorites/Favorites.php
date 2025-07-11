<?php

declare(strict_types=1);

namespace Vvintage\Models\Favorites;

use Vvintage\Models\User\User;
use Vvintage\Models\User\UserInterface;
use Vvintage\Repositories\UserRepository;
use Vvintage\Services\Messages\FlashMessage;

final class Favorites
{
    private array $favorite;

    public function __construct( array $favorite)
    {
        $this->favorite = $favorite;
    }


    public function getItems(): array
    {
        return $this->favorite;
    }

    public function addFavItem(int $productId)
    {
      // Добавляем новый товар
      if (!isset($this->favorite[$productId])) {
          $this->favorite[$productId] = 1;
      }
    }

    public function removeFavItem(int $productId)
    {
        // Удаляем товар из модели
        if (isset($this->favorite[$productId])) {
          unset($this->favorite[$productId]);
        } 
    }

    public function getQuantity(int $productId): int
    {
        return isset($this->favorite[(int)$productId])
            ? (int)$this->favorite[(int)$productId]
            : 0;
    }

    public function getTotalPrice(array $products): int
    {
    
        $total = 0;
        foreach ($this->favorite as $id => $quantity) {
            if (isset($products[$id])) {
                $total = $total + $products[$id]['price'] * $quantity;
            }
        }

        return $total;
    }

    public function isSessionFavStale(): bool
    {
        $sessionFav = json_decode($_SESSION['favorite'] ?? '[]', true);
        return $sessionCFav !== $this->favorite;
    }

}
