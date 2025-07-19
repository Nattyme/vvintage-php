<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Vvintage\Services\User\UserItemsMergeService;
use Vvintage\Services\Cart\CartService;
use Vvintage\Services\Favorites\FavoritesService;
use Vvintage\Models\Shared\AbstractUserItemsList;

final class UserItemsMergeServiceTest extends TestCase
{
  public function testMergeAllAfterLoginCallsServices()
  {
    $cartService = $this->createMock(CartService::class);
    $favService = $this->createMock(FavoritesService::class);

    $userCart = $this->createMock(AbstractUserItemsList::class);
    $guestCart = $this->createMock(AbstractUserItemsList::class);
    $userFav = $this->createMock(AbstractUserItemsList::class);
    $guestFav = $this->createMock(AbstractUserItemsList::class);

    $cartService->expects($this->once())
    ->method('mergeItemsListAfterLogin')
    ->with($userCart, $guestCart);

    $favService->expects($this->once())
    ->method('mergeItemsListAfterLogin')
    ->with($userFav, $guestFav);

    $service = new UserItemsMergeService($cartService, $favService);
    $service->mergeAllAfterLogin($userCart, $guestCart, $userFav, $guestFav);
  }
}