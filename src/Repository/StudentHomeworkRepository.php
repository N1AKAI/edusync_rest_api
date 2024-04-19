<?php

namespace App\Repository;

use App\Base\BaseRepository;

class StudentHomeworkRepository extends BaseRepository
{
  protected $showableFields = ['student_homework', 'homework_id', 'student_id'];

  protected $insertableFields = ['homework_id', 'student_id'];

  protected $updatableFields = ['homework_id', 'student_id'];
  protected $columnId = "student_homework";

  function __construct()
  {
    parent::__construct("student_homework");
  }
}
