<?php

namespace Lib\Routing;

class Route {
  private $parameters;
  private $uri;
  private $controller;
  private $action;

  public function __construct($uri, $routeInfo, $matches) {
    $this->uri = $uri;
    list($this->controller, $this->action) = explode(':', $routeInfo);
    array_shift($matches);
    $this->parameters = $matches;
  }

  public function getParameters() {
    return $this->parameters;
  }

  public function getUri() {
    return $this->uri;
  }

  public function getController() {
    return $this->controller;
  }

  public function getAction() {
    return $this->action;
  }
}
