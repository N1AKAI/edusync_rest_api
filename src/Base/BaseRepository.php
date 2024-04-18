<?php

namespace App\Base;

use App\Database\DatabaseConnection;

class BaseRepository
{

  protected $con;
  protected $table;
  protected $showableFields = [];
  protected $insertableFields = [];
  protected $updatableFields = [];
  protected $columnId = "";

  public function __construct($table)
  {
    $db = new DatabaseConnection;
    $this->con = $db->connect();
    $this->table = $table;
  }

  protected function executeQuery($query, $params = [])
  {
    $stmt = $this->con->prepare($query);
    if (!empty($params)) {
      $types = $this->getBindParamTypes($params);
      $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    return $stmt;
  }

  public function create($data, $passwordField = "")
  {
    if ($passwordField) {
      $data[$passwordField] = password_hash($data[$passwordField], PASSWORD_DEFAULT);
    }
    $insertFields = array_intersect_key($data, array_flip($this->insertableFields));
    $fields = implode(', ', array_keys($insertFields));
    $placeholders = rtrim(str_repeat('?, ', count($insertFields)), ', ');
    $values = array_values($insertFields);

    $query = "INSERT INTO {$this->table} ($fields) VALUES ($placeholders)";
    $stmt = $this->executeQuery($query, $values);

    return $stmt->affected_rows > 0;
  }

  public function update($id, $data, $passwordField = "")
  {
    if ($passwordField && isset($data[$passwordField])) {
      $data[$passwordField] = password_hash($data[$passwordField], PASSWORD_DEFAULT);
    }
    $updateFields = array_intersect_key($data, array_flip($this->updatableFields));
    $set = implode('=?, ', array_keys($updateFields)) . '=?';
    $values = array_values($updateFields);
    $values[] = $id;

    $query = "UPDATE {$this->table} SET $set WHERE {$this->columnId} = ?";
    $stmt = $this->executeQuery($query, $values);

    return $stmt->affected_rows > 0;
  }

  public function delete($id)
  {
    $query = "DELETE FROM {$this->table} WHERE {$this->columnId} = ?";
    $stmt = $this->executeQuery($query, [$id]);

    return $stmt->affected_rows > 0;
  }

  public function fetch($id)
  {
    $fields = implode(', ', array_values($this->showableFields));
    $query = "SELECT $fields FROM {$this->table} WHERE {$this->columnId} = ?";
    $stmt = $this->executeQuery($query, [$id]);

    return $stmt->get_result()->fetch_assoc();
  }

  public function fetchByColumn($column, $value)
  {
    $fields = implode(', ', array_values($this->showableFields));
    $query = "SELECT $fields FROM {$this->table} WHERE $column = ?";

    $stmt = $this->executeQuery($query, [$value]);
    return $stmt->get_result()->fetch_assoc();
  }

  public function getColumnValue($column, $where = "", $value = [])
  {
    $query = "SELECT $column FROM {$this->table} $where";
    $stmt = $this->executeQuery($query, $value);
    $stmt->store_result();
    $stmt->bind_result($col);
    $stmt->fetch();
    return $col;
  }

  public function fetchAll()
  {
    $fields = implode(', ', array_values($this->showableFields));
    $query = "SELECT $fields FROM {$this->table}";
    $stmt = $this->executeQuery($query);

    return $this->getAll($stmt);
  }

  public function count($where = "", $value = [])
  {
    $query = "SELECT COUNT(*) as count FROM {$this->table} $where";
    $stmt = $this->executeQuery($query, $value);
    $stmt->store_result();
    $stmt->bind_result($count);
    $stmt->fetch();
    return $count;
  }

  protected function getAll($stmt)
  {
    $result = $stmt->get_result();
    $rows = [];
    while ($row = $result->fetch_assoc()) {
      $rows[] = $row;
    }
    return $rows;
  }

  protected function getFirstRow($stmt)
  {
    $result = $stmt->get_result();
    return $result->fetch_assoc();
  }

  protected function getBindParamTypes($params)
  {
    $types = '';
    foreach ($params as $param) {
      if (is_int($param)) {
        $types .= 'i'; // Integer type
      } elseif (is_float($param)) {
        $types .= 'd'; // Double type
      } elseif (is_string($param)) {
        $types .= 's'; // String type
      } else {
        $types .= 'b'; // Blob type
      }
    }
    return $types;
  }
}
