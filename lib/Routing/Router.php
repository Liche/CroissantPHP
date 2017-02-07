<?php

namespace Lib\Routing;

class Router {
  protected $routes;

  public function __construct(array $routes) {
    $this->routes = $routes;
  }

  public function match($uri) {
    $uri = $this->normalize($uri);

    foreach ($this->routes as $match => $route) {
      if (preg_match(sprintf("#^%s$#", $uri), $match, $matches)) {
        return new Route($uri, $route, $matches);
      }
    }

    return null;
  }

  protected function normalize($uri) {
    $path = trim(parse_url($uri, PHP_URL_PATH), "/");
    $path = preg_replace('/[^a-zA-Z0-9]\//', "", $path);

    return $path;
  }
}
