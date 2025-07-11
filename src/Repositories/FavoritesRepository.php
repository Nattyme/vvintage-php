<?php

declare(strict_types=1);

namespace Vvintage\Repositories;

use RedBeanPHP\R; // Подключаем readbean
use RedBeanPHP\OODBBean; // для обозначения типа даннных
use Vvintage\Models\Favorites\Favorites;

final class FavoritesRepository
{
    public function getFav(User $user): Favorites
    {
        $favData = json_decode($user->getFav() ?? '[]', true);
        return new Favorites($favData);
    }

    public function saveFav(User $user, Favorites $fav): void
    {
        $user->fav = json_encode($fav->getItems());
        R::store($user);
    }
}
