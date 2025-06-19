<?php
  namespace Vvintage\Routing;

  class RouteData {
    public string $module;
    public ?string $get;
    public ?string $getParam;

    public function __construct(string $module, ?string $get = null, ?string $getParam = null) {
      $this->module = $module;
      $this->get = $get;
      $this->getParam = $getParam;
    }
  }