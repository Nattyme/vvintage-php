<?php

namespace Vvintage\Routing;

class RouteData
{
    public string $uri;
    public string $uriModule;
    public ?string $uriGet;
    public ?string $uriGetParam;

    public function __construct(string $uri, string  $uriModule, ?string $uriGet = null, ?string $uriGetParam = null)
    {
        $this->uri = $uri;
        $this->uriModule = $uriModule;
        $this->uriGet = $uriGet;
        $this->uriGetParam = $uriGetParam;
    }

    public function getUriModule(): string
    {
      return $this->uriModule;
    }
}
