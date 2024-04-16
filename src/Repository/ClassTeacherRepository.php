<?php

namespace App\Repository;

use App\Base\BaseRepository;

class ClassTeacherRepository extends BaseRepository
{

  function __construct()
  {
    parent::__construct('class_teacher');
  }

  public function getCourseByClassId($class_id, $teacher_id)
  {
    $query = "SELECT course_id, course_name, course_code FROM `class_teacher`
    INNER JOIN course USING (course_id)
    WHERE class_id = ? AND teacher_id = ?";
    $params = [$class_id, $teacher_id];
    $stmt = $this->executeQuery($query, $params);
    return $this->getAll($stmt);
  }
}
