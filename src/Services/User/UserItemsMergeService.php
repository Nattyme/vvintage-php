<?php
declare(strict_types=1);

namespace Vvintage\Services\User;

use Vvintage\Services\Cart\CartService;
use Vvintage\Services\Favorites\FavoritesService;
use Vvintage\Models\Shared\AbstractUserItemsList;


final class UserItemsMergeService
{
  private CartService $cartService;
  private FavoritesService $favService;

  public function __construct(FavoritesService $favService, CartService $cartService)
  {
    $this->favService = $favService;
    $this->cartService = $cartService;
  }

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