<?php
declare(strict_types=1);

namespace Vvintage\Services\User;

use Vvintage\Services\Cart\CartService;
use Vvintage\Services\Favorites\FavoritesService;
use Vvintage\Models\Shared\AbstractUserItemsList;


final class UserItemsMergeService
{
  public function __construct(
    private FavoritesService $favService, 
    private CartService $cartService
  ){}

  public function mergeAllAfterLogin(
    AbstractUserItemsList $userCartModel,
    AbstractUserItemsList $guestCartModel,
    AbstractUserItemsList $userFavoritesModel,
    AbstractUserItemsList $guestFavoritesModel,
  ): void
  {

    $this->favService->mergeItemsListAfterLogin($userFavoritesModel, $guestFavoritesModel);
    $this->cartService->mergeItemsListAfterLogin($userCartModel, $guestCartModel);
  }
}