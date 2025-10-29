<?php

namespace Vvintage\Routing;

class RouteData
{
    // PHP 8+ с короткой записью конструктора объявление свойств в начале класса и $this->… = … в конструкторе больше не нужны.
    public function __construct(
      public string $uri, 
      public bool $isAdmin, 
      public ?string  $uriModule, 
      public ?string $uriGet, 
      public array $uriGetParams = []
    )
    {}

    public function getUriModule(): ?string
    {
      return $this->uriModule;
    }

    public static function parseUri(): self
    {
      $uri = explode('?', $_SERVER['REQUEST_URI'])[0];
      $uri = trim($uri, '/');
      $parts = explode('/', $uri);

      $isAdmin = ($parts[0] === 'admin');
      if ($isAdmin) array_shift($parts); // убираем admin

      return new self(
          uri : $uri,
          isAdmin : $isAdmin,
          uriModule : $parts[0] ?? null,
          uriGet : $parts[1] ?? null,
          uriGetParams : array_slice($parts, 2)
      );
    }
}
