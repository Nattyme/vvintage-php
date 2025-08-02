<?php

declare(strict_types=1);

namespace Vvintage\Repositories;

use RedBeanPHP\R; // Подключаем readbean
use RedBeanPHP\OODBBean; // для обозначения типа даннных


/** Контракты */
use Vvintage\Contracts\Favorites\FavoritesRepositoryInterface;

/** Абстрактный репозиторий */
use Vvintage\Repositories\AbstractRepository;

/** Модели */
use Vvintage\Models\Favorites\Favorites;

final class FavoritesRepository extends AbstractRepository implements FavoritesRepositoryInterface
{
    public function getFav(User $user): Favorites
    {
        $favData = json_decode($user->getFav() ?? '[]', true);
        return new Favorites($favData);
    }

    public function saveFav(User $user, Favorites $fav): void
    {
        $user->fav = json_encode($fav->getItems());
        $this->saveBean($user);
    }
}
