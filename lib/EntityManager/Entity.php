<?php

namespace Lib\EntityManager;

abstract class Entity {
  protected $isNew;
  protected $fields;

  public function __construct() {
    $this->isNew = true;
    $this->fields = [];
  }

  public function setNew($new) {
    $this->isNew = $new;
  }

  public function isNew() {
    return $this->isNew;
  }

  public function getFields() {
    return $this->fields;
  }

  public function get($field) {
    return $this->fields[$field];
  }

  public function set($field, $value) {
    if (!in_array($field, $this->fieldNames())) {
      throw new EntityException(sprintf("Field name %s not supported", $field));
    }

    $this->fields[$field] = $value;

    return $this;
  }

  public function setFields(array $values) {
    foreach ($values as $field => $value) {
      $this->set($field, $value);
    }
  }

  public abstract function fieldNames();
  public abstract function tableName();
  public abstract function primaryKey();
}
