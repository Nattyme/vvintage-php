<?php

declare(strict_types=1);

namespace Vvintage\Models\Cart;

use Vvintage\Models\Shared\AbstractUserItemsList;
use Vvintage\Models\User\User;
use Vvintage\Models\User\UserInterface;
use Vvintage\Repositories\UserRepository;
use Vvintage\Repositories\CartRepository;


final class Cart extends AbstractUserItemsList
{
    public function getSessionKey(): string
    {
        return 'cart';
    }


    public function getTotalPrice(array $products): int
    {
        // создаём словарь: productId => Product
        $productMap = [];
        foreach ($products as $product) {
            $productMap[$product->getId()] = $product;
        }

        // считаем сумму
        $total = 0;
        foreach ($this->items as $id => $quantity) {
            if (isset($productMap[$id])) {
                $total += $productMap[$id]->getPrice() * $quantity;
            }
        }

        return $total;
    }

}


// final class Cart extends AbstractUserProductList
// {
//      public function getSessionKey(): string
//     {
//         return 'cart';
//     }

//     public function getQuantity(int $productId): int
//     {
//         return isset($this->items[(int)$productId])
//             ? (int)$this->items[(int)$productId]
//             : 0;
//     }

//     public function getTotalPrice(array $products): int
//     {
    
//         $total = 0;
//         foreach ($this->items as $id => $quantity) {
//             if (isset($products[$id])) {
//                 $total = $total + $products[$id]['price'] * $quantity;
//             }
//         }

//         return $total;
//     }

//     public function isSessionitemsStale(): bool
//     {
//         $sessionCart = json_decode($_SESSION['cart'] ?? '[]', true);
//         return $sessionCart !== $this->items;
//     }

// }
