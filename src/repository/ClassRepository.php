<?php

namespace App\Repository;

use App\Database\DatabaseConnection;

class ClassRepository
{
  private $con;
  function __construct()
  {
    $db = new DatabaseConnection;
    $this->con = $db->connect();
  }

  public function createClass($class_name, $year, $remarks, $teacher_id)
  {
    $stmt = $this->con->prepare("INSERT INTO class (class, year, remarks, teacher_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $class_name, $year, $remarks, $teacher_id);
    if ($stmt->execute()) {
      return CLASS_CREATED;
    } else {
      return CLASS_FAILURE;
    }
  }

  public function getClassById($class_id = null)
  {
    $where = "";
    if ($class_id) {
      $where = "WHERE class_id = ?";
    }
    $stmt = $this->con->prepare("SELECT * FROM class $where");
    if ($where != "") {
      $stmt->bind_param("i", $class_id);
    }
    $stmt->execute();
    if ($class_id) {
      $stmt->bind_result($class_id, $class_name, $year, $remarks, $teacher_id, $created_at, $updated_at);
      if ($stmt->fetch()) {
        $class = array(
          'class_id' => $class_id,
          'class_name' => $class_name,
          'year' => $year,
          'remarks' => $remarks,
          'teacher_id' => $teacher_id,
          'created_at' => $created_at,
          'updated_at' => $updated_at
        );
        return $class;
      }
      return false;
    } else {
      $result = $stmt->get_result();
      return $result->fetch_all(MYSQLI_ASSOC);
    }
  }

  public function updateClass($class_id, $class_name, $year, $remarks, $teacher_id)
  {
    $stmt = $this->con->prepare("UPDATE class SET class = ?, year = ?, remarks = ?, teacher_id = ?, updated_at = CURRENT_TIMESTAMP WHERE class_id = ?");
    $stmt->bind_param("ssssi", $class_name, $year, $remarks, $teacher_id, $class_id);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
      return true;
    }
    return false;
  }

  public function deleteClass($class_id)
  {
    $stmt = $this->con->prepare("DELETE FROM class WHERE class_id = ?");
    $stmt->bind_param("i", $class_id);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
      return true;
    }
    return false;
  }

  public function isStudentInClass($student_id, $class_id)
  {
    $stmt = $this->con->prepare("SELECT * FROM class
    INNER JOIN class_student USING (class_id)
    WHERE class_id = ? AND class_student.student_id = ?");
    $stmt->bind_param("ii", $class_id, $student_id);
    $stmt->execute();
    if ($stmt->fetch()) {
      return true;
    }
    return false;
  }
}
