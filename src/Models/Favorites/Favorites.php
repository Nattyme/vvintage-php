<?php

declare(strict_types=1);

namespace Vvintage\Models\Favorites;

use Vvintage\Models\Shared\AbstractUserItemsList;
use Vvintage\Models\User\User;
use Vvintage\Models\User\UserInterface;
use Vvintage\Repositories\UserRepository;

final class Favorites extends AbstractUserItemsList
{
    public function getSessionKey(): string
    {
        return 'fav_list';
    }

}