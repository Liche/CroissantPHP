<?php

final class Routing {

  public static function getRoutes() {
    return [
      'test' => 'Test\Controller\TestController:testAction'
    ];
  }

  private function __construct() {}
}
