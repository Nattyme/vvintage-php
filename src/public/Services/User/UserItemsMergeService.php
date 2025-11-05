<?php
declare(strict_types=1);

namespace Vvintage\Public\Services\User;

/** Репозитории */
use Vvintage\Repositories\User\UserRepository;

use Vvintage\Models\Cart\Cart;
use Vvintage\Models\Favorites\Favorites;
use Vvintage\Models\User\User;
use Vvintage\Models\Shared\AbstractUserItemsList;

use Vvintage\Public\Services\Cart\CartService;
use Vvintage\Public\Services\Product\ProductService;
use Vvintage\Public\Services\Favorites\FavoritesService;

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