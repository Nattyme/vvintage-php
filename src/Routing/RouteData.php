<?php

namespace Vvintage\Routing;

class RouteData
{
    public string $uriModule;
    public ?string $uriGet;
    public ?string $uriGetParam;

    public function __construct(string  $uriModule, ?string $uriGet = null, ?string $uriGetParam = null)
    {
        $this->uriModule = $uriModule;
        $this->uriGet = $uriGet;
        $this->uriGetParam = $uriGetParam;
    }
}
