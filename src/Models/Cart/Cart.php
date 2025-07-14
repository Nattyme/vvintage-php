<?php

declare(strict_types=1);

namespace Vvintage\Models\Cart;

use Vvintage\Models\Shared\AbstractUserProductList;
use Vvintage\Models\User\User;
use Vvintage\Models\User\UserInterface;
use Vvintage\Repositories\UserRepository;
use Vvintage\Services\Messages\FlashMessage;

final class Cart extends AbstractUserProductList
{
    private array $cart;

    public function __construct( array $cart)
    {
        $this->cart = $cart;
    }


    public function getItems(): array
    {
        return $this->cart;
    }

    public function addCartItem(int $productId)
    {
      // Добавляем новый товар
      if (!isset($this->cart[$productId])) {
          $this->cart[$productId] = 1;
      }
    }

    public function removeCartItem(int $productId)
    {
        // Удаляем товар из модели
        if (isset($this->cart[$productId])) {
          unset($this->cart[$productId]);
        } 
    }

    public function getQuantity(int $productId): int
    {
        return isset($this->cart[(int)$productId])
            ? (int)$this->cart[(int)$productId]
            : 0;
    }

    public function getTotalPrice(array $products): int
    {
    
        $total = 0;
        foreach ($this->cart as $id => $quantity) {
            if (isset($products[$id])) {
                $total = $total + $products[$id]['price'] * $quantity;
            }
        }

        return $total;
    }

    public function isSessionCartStale(): bool
    {
        $sessionCart = json_decode($_SESSION['cart'] ?? '[]', true);
        return $sessionCart !== $this->cart;
    }

}
