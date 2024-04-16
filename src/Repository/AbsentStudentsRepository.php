<?php

namespace App\Repository;

use App\Base\BaseRepository;

class AbsentStudentsRepository extends BaseRepository
{
  protected $showableFields = ['absent_students_id', 'student_id', 'date', 'class_id', 'teacher_id', 'start_time', 'end_time'];

  protected $insertableFields = ['student_id', 'date', 'class_id', 'teacher_id', 'start_time', 'end_time'];

  protected $updatableFields = ['student_id', 'date', 'class_id', 'teacher_id', 'start_time', 'end_time'];
  protected $columnId = "absent_students_id";


  function __construct()
  {
    parent::__construct("absent_students");
  }

  public function registerAttendance($data)
  {
    return $this->create($data);
  }

}