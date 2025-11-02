<?php

declare(strict_types=1);

namespace Vvintage\Models\Cart;

use Vvintage\Models\User\User;
use Vvintage\Models\Shared\AbstractUserItemsList;
use Vvintage\Models\User\UserInterface;
use Vvintage\Repositories\UserRepository;


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
            $productMap[$product->id] = $product;
        }

        // считаем сумму
        $total = 0;
        foreach ($this->items as $id => $quantity) {
            if (isset($productMap[$id])) {
                $total += $productMap[$id]->price * $quantity;
            }
        }

        return $total;
    }

}

