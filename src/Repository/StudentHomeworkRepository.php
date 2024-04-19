<?php

namespace App\Repository;

use App\Base\BaseRepository;

class StudentHomeworkRepository extends BaseRepository
{
  protected $showableFields = ['student_homework', 'homework_id', 'student_id'];

  protected $insertableFields = ['homework_id', 'student_id'];

  protected $updatableFields = ['homework_id', 'student_id'];
  protected $columnId = "homework_id";

  function __construct()
  {
    parent::__construct("student_homework");
  }
}
