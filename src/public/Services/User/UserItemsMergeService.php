<?php
declare(strict_types=1);

namespace Vvintage\public\Services\User;

/** Репозитории */
use Vvintage\Repositories\User\UserRepository;

use Vvintage\Models\Cart\Cart;
use Vvintage\Models\Favorites\Favorites;
use Vvintage\Models\User\User;
use Vvintage\Models\Shared\AbstractUserItemsList;

use Vvintage\public\Services\Cart\CartService;
use Vvintage\public\Services\Product\ProductService;
use Vvintage\public\Services\Favorites\FavoritesService;

/** Хранилища */
use Vvintage\Store\UserItemsList\GuestItemsListStore;
use Vvintage\Store\UserItemsList\UserItemsListStore;


final class UserItemsMergeService
{
 
  public function mergeAllAfterLogin( 
    User $user,
    array $userModels, 
    array $guestModels, 
    ProductService $productService
  ): array
  {
     
    
      // Создаем сервисы для корзины и избранного
      $cartService = new CartService(
        $user, 
        $guestModels['cart'], 
        $guestModels['cart']->getItems(), 
        $userModels['store'], 
        $productService
      );

      $favService = new FavoritesService(
        $user, 
        $guestModels['fav'], 
        $guestModels['fav']->getItems(), 
        $userModels['store'], 
        $productService
      );

      $mergedFav = $favService->mergeItemsListAfterLogin($userModels['fav'], $guestModels['fav']);
      $mergedCart = $cartService->mergeItemsListAfterLogin($userModels['cart'], $guestModels['cart']);
      
      return [
        'cart' => $mergedCart,
        'fav_list' => $mergedFav
      ];
  }

 
}