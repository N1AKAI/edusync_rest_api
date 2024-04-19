<?php

namespace App\Repository;

use App\Base\BaseRepository;
use App\Database\DatabaseConnection;

class HomeworkRepository extends BaseRepository
{

  protected $showableFields = ['homework_id', 'class_id', 'teacher_id', 'course_id', 'homework', 'created_at', 'updated_at'];
  protected $insertableFields = ['class_id', 'teacher_id', 'course_id', 'homework', 'description'];
  protected $updatableFields = ['class_id', 'teacher_id', 'course_id', 'homework',  'description'];
  protected $columnId = "homework_id";

  function __construct()
  {
    parent::__construct("homework");
  }

  public function getAllHomeWorkByStudent($student_id)
  {
    $query = "SELECT homework.homework_id, homework, course_name, homework.created_at
    CASE WHEN student_homework.student_id IS NOT NULL THEN true ELSE false END AS finished
    FROM homework
    INNER JOIN course USING (course_id)
    INNER JOIN class USING (class_id)
    INNER JOIN class_student USING (class_id)
    LEFT JOIN 
    student_homework ON homework.homework_id = student_homework.homework_id AND class_student.student_id = student_homework.student_id
    WHERE class_student.student_id = ?
    ORDER BY homework.homework_id DESC";
    $params = [$student_id];
    $stmt = $this->executeQuery($query, $params);
    return $this->getAll($stmt);
  }

  public function getTeachersHomeworks($id)
  {
    $query = "SELECT homework_id, homework, class_id, class_name
    FROM homework
    INNER JOIN class USING (class_id)
    WHERE teacher_id = ?";
    $params = [$id];
    $stmt = $this->executeQuery($query, $params);
    return $this->getAll($stmt);
  }
}
