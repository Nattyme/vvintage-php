<?php
declare(strict_types=1);

use Vvintage\Services\SEO\SeoService;
use Vvintage\Services\Session\SessionService;
use Vvintage\Services\Navigation\NavigationService;
use Vvintage\Services\Messages\FlashMessage;

// Пример
$container = new Container();

// Services
$container->set(LocaleService::class, fn() => new LocaleService());
$container->set(FlashMessage::class, fn() => new FlashMessage());
$container->set(SeoService::class, fn($c) => new SeoService(
    $c->get(LocaleService::class),
    $c->get(FlashMessage::class)
));

return $container;
