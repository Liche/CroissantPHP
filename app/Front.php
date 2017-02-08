<?php

use Lib\Routing\Router;
use Lib\Http\Response\BaseResponse;

require_once "Routing.php";

class Front {
    public function run() {
      $router = new Router(Routing::getRoutes());
      $route = $router->match($_SERVER["REQUEST_URI"]);
      if (!$route) {
        $response = new BaseResponse("", 404);
      } else {
        $controllerClass = $route->getController();
        $controller = new $controllerClass();
        $response = call_user_func(
          [$controller, $route->getAction()],
          $route->getParameters()
        );
      }

      $response->render();
    }
}
