<?php

namespace Lib\EntityManager;

class EntityManager {
  private static $manager;
  private $dbHandle;

  public function fetchAll($entityClass) {
    $entity = new $entityClass();
    $query = "SELECT * FROM %s";
    $result = $this->dbHandle->query(sprintf(
      "SELECT * FROM %s",
      $entity->tableName()
    ));

    $entities = [];
    while ($row = $result->fetchArray()) {
      $entity = new $entityClass();
      $row = array_intersect_key($row, array_flip($entity->fieldNames()));
      $entities[] = $this->hydrateResult($entity, $row);
    }

    return $entities;
  }

  public function store(Entity $entity) {
    if ($entity->isNew()) {
      $query = "INSERT INTO %s(%s) VALUES(%s)";
      $keys = [];
      $values = [];

      foreach ($entity->getFields() as $key => $value) {
        $keys[] = $key;
        $values[] = '\'' . \SQLite3::escapeString($value) .'\'';
      }

      $result = $this->dbHandle->query(sprintf(
        $query,
        $entity->tableName(),
        implode(',', $keys),
        implode(',', $values)
      ));
    } else {
      $query = "UPDATE %s SET %s WHERE %s";
      $fields = array_diff_key($entity->getFields(), array_flip($entity->primaryKey()));
      $update = [];
      foreach ($fields as $key => $value) {
        $update[] = sprintf('%s = \'%s\'', $key, \SQLite3::escapeString($value));
      }

      $primaryKey = $this->getPrimaryKey($entity);

      $pkArgs = [];
      foreach ($primaryKey as $field => $value) {
        $pkArgs[] = sprintf(
          '%s=%s',
          $field,
          \SQLite3::escapeString($value)
        );
      }

      $result = $this->dbHandle->query(sprintf(
        $query,
        $entity->tableName(),
        implode(',', $update),
        implode(' AND ', $pkArgs))
      );
    }

    if (!$result) {
      throw new EntityException('Error while querying the DB');
    }

    $entity->setNew(false);

    return $entity;
  }

  public function fetch(Entity $entity) {
    $primaryKey = $this->getPrimaryKey($entity);

    $queryArgs = [];
    foreach ($primaryKey as $field => $value) {
      $queryArgs[] = sprintf(
        '%s=%s',
        $field,
        \SQLite3::escapeString($value)
      );
    }

    $result = $this->dbHandle->querySingle(sprintf(
      "SELECT * FROM %s WHERE %s",
      $entity->tableName(),
      implode(' AND ', $queryArgs)
    ), true);

    return $this->hydrateResult($entity, $result);
  }

  public function delete(Entity $entity) {
    $primaryKey = $this->getPrimaryKey($entity);

    $queryArgs = [];
    foreach ($primaryKey as $field => $value) {
      $queryArgs[] = sprintf(
        '%s=%s',
        $field,
        \SQLite3::escapeString($value)
      );
    }

    $result = $this->dbHandle->querySingle(sprintf(
      "DELETE FROM %s WHERE %s",
      $entity->tableName(),
      implode(' AND ', $queryArgs)
    ));

    return $result;
  }

  public function query(string $query) {
    return $this->query($query);
  }

  private function hydrateResult(Entity $entity, array $result) {
    if (!$result) {
      return null;
    }

    $entity->setNew(false);
    $entity->setFields($result);

    return $entity;
  }

  private function getPrimaryKey(Entity $entity) {
    $primaryKey = array_filter(array_intersect_key(
      $entity->getFields(),
      array_flip($entity->primaryKey())
    ));

    if (count($primaryKey) !== count($entity->primaryKey())) {
      throw new EntityException("Impossible to fetch with non complete PK");
    }

    return $primaryKey;
  }

  public function getLastInsertedRowId() {
    return $this->dbHandle->lastInsertRowID();
  }

  public static function getManager() {
    if (!static::$manager) {
      static::$manager = new static();
    }

    return static::$manager;
  }

  private function __construct() {
      $this->dbHandle = new \SQLite3(__DIR__ . '/../../db/db.db');
  }

  private function __clone() {}

  private function __wakeup() {}
}
