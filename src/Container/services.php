<?php
use App\Container\Container;
use App\Services\LocaleService;
use App\Services\Messages\FlashMessage;
use App\Services\SeoService;

$container = new Container();

$container->set(LocaleService::class, fn() => new LocaleService());
$container->set(FlashMessage::class, fn() => new FlashMessage());
$container->set(SeoService::class, fn($c) => new SeoService(
    $c->get(LocaleService::class),
    $c->get(FlashMessage::class)
));

return $container;
