<?php

namespace App\Repository;

use App\Database\DatabaseConnection;

class HomeworkRepository
{
  private $con;
  function __construct()
  {
    $db = new DatabaseConnection;
    $this->con = $db->connect();
  }

  public function getAllHomeWorkByStudent($student_id)
  {
    $stmt = $this->con->prepare("SELECT homework.homework_id, homework, course_name, homework.created_at,
    CASE WHEN student_homework.student_id IS NOT NULL THEN true ELSE false END AS finished
    FROM homework
    INNER JOIN course USING (course_id)
    INNER JOIN class USING (class_id)
    INNER JOIN class_student USING (class_id)
    LEFT JOIN 
    student_homework ON homework.homework_id = student_homework.homework_id AND class_student.student_id = student_homework.student_id
    WHERE class_student.student_id = ?
    ORDER BY homework.homework_id DESC");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $homeworks = [];
    while ($row = $result->fetch_assoc()) {
      $homeworks[] = $row;
    }
    return $homeworks;
  }

  public function getTeachersHomeworks($id)
  {
    $stmt = $this->con->prepare("SELECT homework_id, homework, class_id, class_name
    FROM homework
    INNER JOIN class USING (class_id)
    WHERE teacher_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $homeworks = [];
    while ($row = $result->fetch_assoc()) {
      $homeworks[] = $row;
    }
    return $homeworks;
  }
}
