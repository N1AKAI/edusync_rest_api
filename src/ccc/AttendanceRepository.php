<?php

namespace App\Repository;

use App\Database\DatabaseConnection;

class AttendanceRepository
{
  private $con;
  function __construct()
  {
    $db = new DatabaseConnection;
    $this->con = $db->connect();
  }

  public function getStudentsAttendace($id)
  {
    $sql = "SELECT 
    student_id,
    attendance_id,
    date,
    is_present,
    class_id,
    teacher_id,
    session_id,
    MONTH(date) AS month,
    YEAR(date) AS year,
    SUM(CASE WHEN is_present = 1 THEN 1 ELSE 0 END) AS total_present,
    SUM(CASE WHEN is_present = 0 THEN 1 ELSE 0 END) AS total_absent,
    SUM(CASE WHEN is_present = 2 THEN 1 ELSE 0 END) AS total_leave
    FROM 
        Attendance
    WHERE
        student_id = ?
    GROUP BY 
        student_id, YEAR(date), MONTH(date)
    ORDER BY 
        student_id, YEAR(date), MONTH(date)";

    $stmt = $this->con->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $attendances = [];
    if ($row = $result->fetch_assoc()) {
      $attendances[] = $row;
    }
    return $attendances;
  }
}
