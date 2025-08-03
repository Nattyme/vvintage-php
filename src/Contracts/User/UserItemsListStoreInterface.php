<?php
declare(strict_types=1);

namespace Vvintage\Contracts\User;

/** Контракт */
use Vvintage\Contracts\User\UserInterface;

use Vvintage\Models\Cart\Cart;

interface UserItemsListStoreInterface 
{
  public function load($itemKey): array;
  public function save($itemKey, $itemModel, ?UserInterface $userModel = null): void;
}