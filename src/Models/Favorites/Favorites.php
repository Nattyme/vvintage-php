<?php

declare(strict_types=1);

namespace Vvintage\Models\Favorites;

use Vvintage\Models\Shared\AbstractUserItemsList;
use Vvintage\Models\User\User;
use Vvintage\Models\User\UserInterface;
use Vvintage\Repositories\UserRepository;

final class Favorites extends AbstractUserItemsList
{
    public function getSessionKey(): string
    {
        return 'fav_list';
    }
}


// final class Favorites extends AbstractUserProductList
// {
//     public function getSessionKey(): string
//     {
//         return 'fav_list';
//     }

//     public function getQuantity(int $productId): int
//     {
//         return isset($this->favorites[(int)$productId])
//             ? (int)$this->favorites[(int)$productId]
//             : 0;
//     }

//     public function getTotalPrice(array $products): int
//     {
    
//         $total = 0;
//         foreach ($this->favorites as $id => $quantity) {
//             if (isset($products[$id])) {
//                 $total = $total + $products[$id]['price'] * $quantity;
//             }
//         }

//         return $total;
//     }

//     public function isSessionFavStale(): bool
//     {
//         $sessionFav = json_decode($_SESSION['fav_list'] ?? '[]', true);
//         return $sessionCFav !== $this->favorite;
//     }

// }
