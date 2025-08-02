<?php
declare(strict_types=1);

namespace Vvintage\Contracts\Favorites;

use Vvintage\Models\Favorites\Favorites;

interface FavoritesRepositoryInterface
 {    
    public function getFav(User $user): Favorites;

    public function saveFav(User $user, Favorites $fav): void;
  }
