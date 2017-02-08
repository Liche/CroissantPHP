<?php

final class Routing {

  public static function getRoutes() {
    return [
      'test' => 'Test\Controller\TestController:testAction',
      'foods/([0-9]+)' => 'Test\Controller\FoodController:oneAction',
      'foods' => 'Test\Controller\FoodController:manyAction',
    ];
  }

  private function __construct() {}
}
