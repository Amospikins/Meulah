<?php

/**
 * PDO Database Class
 * - Connects to the database
 * - Creates prepared statements
 * - Executes queries safely
 * - Returns results
 */
class Database
{
  private $host = DB_HOST;
  private $user = DB_USER;
  private $pass = DB_PASS;
  private $dbname = DB_NAME;
  private $dbh;
  private $stmt;

  public function __construct()
  {
    $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";
    $options = [
      PDO::ATTR_PERSISTENT => true,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    try {
      $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
    } catch (PDOException $e) {
      throw new Exception("Database Connection Error: " . $e->getMessage());
    }
  }

  // Prepare statement
  public function query($sql)
  {
    $this->stmt = $this->dbh->prepare($sql);
  }

  // Bind values
  public function bind($param, $value, $type = null)
  {
    if ($type === null) {
      $type = match (true) {
        is_int($value) => PDO::PARAM_INT,
        is_bool($value) => PDO::PARAM_BOOL,
        is_null($value) => PDO::PARAM_NULL,
        default => PDO::PARAM_STR,
      };
    }
    $this->stmt->bindValue($param, $value, $type);
  }

  // Execute statement
  public function execute()
  {
    return $this->stmt->execute();
  }

  //  Get result set as array of objects
  public function resultSet()
  {
    $this->execute();
    return $this->stmt->fetchAll(PDO::FETCH_OBJ);
  }

  // Fetch a single result as object
  public function single()
  {
    $this->execute();
    return $this->stmt->fetch(PDO::FETCH_OBJ);
  }

  // Get row count
  public function rowCount()
  {
    return $this->stmt->rowCount();
  }

  // Get last inserted ID
  public function lastInsertId()
  {
    return $this->dbh->lastInsertId();
  }

  // Returns total count of rows (Requires a proper COUNT query)
  public function countRow()
  {
    $this->execute();
    return $this->stmt->fetchColumn();
  }

  /**
   * Fetch a single column value
   */
  public function fetchColumn()
  {
    $this->execute();
    return $this->stmt->fetchColumn();
  }

  /**
   * Check if a record exists
   */
  public function exists($table, $column, $value)
  {
    $sql = "SELECT COUNT(*) FROM {$table} WHERE {$column} = :value";
    $this->query($sql);
    $this->bind(":value", $value);
    return $this->fetchColumn() > 0;
  }

  /**
   * Delete a record
   */
  public function delete($table, $column, $value)
  {
    $sql = "DELETE FROM {$table} WHERE {$column} = :value";
    $this->query($sql);
    $this->bind(":value", $value);
    return $this->execute();
  }

  /**
   * Update a record
   */
  public function update($table, $data, $whereColumn, $whereValue)
  {
    $set = "";
    foreach ($data as $column => $value) {
      $set .= "{$column} = :{$column}, ";
    }
    $set = rtrim($set, ", ");

    $sql = "UPDATE {$table} SET {$set} WHERE {$whereColumn} = :whereValue";
    $this->query($sql);

    foreach ($data as $column => $value) {
      $this->bind(":{$column}", $value);
    }
    $this->bind(":whereValue", $whereValue);

    return $this->execute();
  }

  /**
   * Begin transaction
   */
  public function beginTransaction()
  {
    return $this->dbh->beginTransaction();
  }

  /**
   * Commit transaction
   */
  public function commit()
  {
    return $this->dbh->commit();
  }

  /**
   * Rollback transaction
   */
  public function rollback()
  {
    return $this->dbh->rollBack();
  }
  // Close the database connection when object is destroyed
  public function __destruct()
  {
    $this->dbh = null;
  }
}