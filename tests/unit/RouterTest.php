<?php

namespace Lib;

class RouterTest extends \PHPUnit_Framework_TestCase {
  /**
   * @test
   */
  public function match() {
    $routes = [
      'test/route1' => 'TestController:Route1',
      'test/route2' => 'TestController:Route2',
      'test/route3' => 'Test3Controller:Route3',
    ];
    $router = new Router($routes);

    $route = $router->match('test/route1');

    $this->assertNotNull($route);
    $this->assertInstanceOf('Lib\Route', $route);

    $this->assertEquals('TestController', $route->getController());
    $this->assertEquals('Route1', $route->getAction());

    $route = $router->match('test/route2?get_parameter=test');

    $this->assertNotNull($route);
    $this->assertInstanceOf('Lib\Route', $route);

    $this->assertEquals('TestController', $route->getController());
    $this->assertEquals('Route2', $route->getAction());
  }

  /**
   * @test
   */
  public function nonMatch() {
    $routes = [
      'test/route1' => 'TestController:Route1',
      'test/route2' => 'TestController:Route2',
      'test/route3' => 'Test3Controller:Route3',
    ];
    $router = new Router($routes);

    $route = $router->match('test/wrongroute');

    $this->assertNull($route);
  }
}
