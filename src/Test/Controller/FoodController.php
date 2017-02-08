<?php

namespace Test\Controller;

use Lib\EntityManager\EntityManager;
use Lib\Http\Verb;
use Lib\Http\JsonResponse;
use Test\Entity\Food;

class FoodController {
  public function manyAction(array $parameters) {
    switch (Verb::getVerb()) {
      case Verb::GET:
        $foods = EntityManager::getManager()->fetchAll(Food::class);
        $result = [];
        foreach($foods as $food) {
          $result[] = $food->toArray();
        }

        return new JsonResponse($result);
        break;
      case Verb::POST:
        $food = new Food();
        $food->setFields($_POST);
        EntityManager::getManager()->store($food);
        return new JsonResponse($food->toArray());
        break;
    }

  }

  public function oneAction(array $parameters) {
    $entityManager = EntityManager::getManager();
    $food = new Food();
    $food->set('id', $parameters[0]);
    $food = $entityManager->fetch($food);

    switch (Verb::getVerb()) {
      case Verb::GET:
        break;
      case Verb::PUT:
        parse_str(file_get_contents("php://input"), $putData);

        $food->setFields($putData);
        $entityManager->store($food);
        break;
      case Verb::DELETE:
        $entityManager->delete($food);
        break;
    }

    return new JsonResponse($food->toArray());
  }
}
