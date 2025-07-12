<?php

declare(strict_types=1);

namespace Vvintage\Models\Favorites;

use Vvintage\Models\User\User;
use Vvintage\Models\User\UserInterface;
use Vvintage\Repositories\UserRepository;
use Vvintage\Services\Messages\FlashMessage;

final class Favorites
{
    private array $favorites;

    public function __construct( array $favorites)
    {
        $this->favorites = $favorites;
    }


    public function getItems(): array
    {
        return $this->favorites;
    }

    public function addFavItem(int $productId)
    {
      // Добавляем новый товар
      if (!isset($this->favorites[$productId])) {
          $this->favorites[$productId] = 1;
      }
    }

    public function removeFavItem(int $productId)
    {
        // Удаляем товар из модели
        if (isset($this->favorites[$productId])) {
          unset($this->favorites[$productId]);
        } 
    }

    public function getQuantity(int $productId): int
    {
        return isset($this->favorites[(int)$productId])
            ? (int)$this->favorites[(int)$productId]
            : 0;
    }

    public function getTotalPrice(array $products): int
    {
    
        $total = 0;
        foreach ($this->favorites as $id => $quantity) {
            if (isset($products[$id])) {
                $total = $total + $products[$id]['price'] * $quantity;
            }
        }

        return $total;
    }

    public function isSessionFavStale(): bool
    {
        $sessionFav = json_decode($_SESSION['fav_list'] ?? '[]', true);
        return $sessionCFav !== $this->favorite;
    }

}
