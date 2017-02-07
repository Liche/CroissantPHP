<?php

use Lib\Routing\Router;
use Lib\Http\Response;

require_once "Routing.php";

class Front {
    public function run() {
      $router = new Router(Routing::getRoutes());
      $route = $router->match($_SERVER["REQUEST_URI"]);
      if (!$route) {
        $response = new Response("", 404);
      } else {
        $controllerClass = $route->getController();
        $controller = new $controllerClass();
        $response = call_user_func(array($controller, $route->getAction()));
      }

      $response->render();
    }
}
