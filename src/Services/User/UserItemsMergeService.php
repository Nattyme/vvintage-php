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

  public function __construct(CartService $cartService, FavoritesService $favService)
  {
    $this->cartService = $cartService;
    $this->favService = $favService;
  }

  public function mergeAllAfterLogin(
    AbstractUserItemsList $userCartModel,
    AbstractUserItemsList $guestCartModel,
    AbstractUserItemsList $userFavoritesModel,
    AbstractUserItemsList $guestFavoritesModel,
  ): void
  {

    $this->cartService->mergeItemsListAfterLogin($userCartModel, $guestCartModel);
    $this->favService->mergeItemsListAfterLogin($userFavoritesModel, $guestFavoritesModel);
  }
}