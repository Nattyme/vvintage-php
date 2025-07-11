<?php
declare(strict_types=1);

namespace Vvintage\Store\Favorites;

use Vvintage\Models\User\UserInterface;
use Vvintage\Models\Favorites\Favorites;

interface FavoritesInterface 
{
  public function save(Favorites $favModel, ?UserInterface $userModel = null): void;

}