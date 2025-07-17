<?php
declare(strict_types=1);

namespace Vvintage\Store\UserItemsList;

use Vvintage\Models\User\UserInterface;
use Vvintage\Models\Cart\Cart;

interface ItemsListStoreInterface 
{
  public function load($itemKey): array;
  public function save($itemKey, $itemModel, ?UserInterface $userModel = null): void;
}