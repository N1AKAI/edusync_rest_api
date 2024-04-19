<?php

namespace App\Repository;

use App\Database\DatabaseConnection;

class TestOnlineRepository
{
  private $con;
  function __construct()
  {
    $db = new DatabaseConnection;
    $this->con = $db->connect();
  }

  public function getTestsOnline($student_id)
  {
    $stmt = $this->con->prepare("SELECT class_id,
    test_online.test_online_id, test_online_name, duration, score,
    course_name
    FROM test_online
    INNER JOIN course USING (course_id)
    INNER JOIN class USING (class_id)
    INNER JOIN class_student USING (class_id)
    LEFT JOIN test_online_student USING (student_id)
    WHERE student_id = ?
    ORDER BY test_online.test_online_id DESC");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $tests = [];
    while ($row = $result->fetch_assoc()) {
      $tests[] = $row;
    }
    return $tests;
  }

  public function submit()
  {
  }
}
