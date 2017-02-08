<?php

namespace Lib\EntityManager;

use Test\Entity\Food;

class EntityManagerTest extends \PHPUnit_Framework_TestCase {
  /**
   * @test
   */
  public function storeFetchAndDelete() {
    $manager = EntityManager::getManager();

    $food = new Food();
    $food->setFields([
      'name' => 'test',
      'quantity' => 3
    ]);

    $food = $manager->store($food);
    $this->assertInstanceOf('Test\Entity\Food', $food);

    $rowId = $manager->getLastInsertedRowId();
    $this->assertNotEmpty($rowId);

    $fetchedFood = new Food();
    $fetchedFood->set('id', $rowId);

    $fetchedFood = $manager->fetch($fetchedFood);
    $this->assertInstanceOf('Test\Entity\Food', $fetchedFood);
    $this->assertEquals('test', $fetchedFood->get('name'));
    $this->assertEquals(3, $fetchedFood->get('quantity'));

    $manager->delete($fetchedFood);
    $fetchedFood = $manager->fetch($fetchedFood);
    $this->assertNull($fetchedFood);
  }

  /**
   * @test
   */
   public function fetchAll() {
     $manager = EntityManager::getManager();

     $food = new Food();
     $food->setFields([
       'name' => 'test',
       'quantity' => 3
     ]);

     $food = $manager->store($food);
     $this->assertInstanceOf('Test\Entity\Food', $food);

     $rowId = $manager->getLastInsertedRowId();

     $foods = $manager->fetchAll(Food::class);

     $this->assertInternalType('array', $foods);
     foreach($foods as $food) {
       $this->assertInstanceOf('Test\Entity\Food', $food);
     }

     $fetchedFood = new Food();
     $fetchedFood->set('id', $rowId);
     $manager->delete($fetchedFood);
   }
}
