<?php

namespace App\Repository;

use App\Database\DatabaseConnection;

class QuestionRepository
{
  private $con;
  function __construct()
  {
    $db = new DatabaseConnection;
    $this->con = $db->connect();
  }
}