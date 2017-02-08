<?php

namespace Test\Entity;

use Lib\EntityManager\Entity;

class Food extends Entity {
  public function fieldNames() {
    return ['id', 'name', 'quantity'];
  }
  public function tableName() {
    return 'food';
  }
  public function primaryKey() {
    return ['id'];
  }

  public function toArray() {
    return $this->getFields();
  }
}
