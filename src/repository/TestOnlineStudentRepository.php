<?php

namespace App\Repository;

use App\Database\DatabaseConnection;

class TestOnlineStudentRepository
{
  private $con;
  function __construct()
  {
    $db = new DatabaseConnection;
    $this->con = $db->connect();
  }

  public function submit($student_id, $test_online_id, $score)
  {
    $stmt = $this->con->prepare("INSERT INTO test_online_student
    VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $test_online_id, $student_id, $score);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
      return true;
    }
    return false;
  }
}
