<?php

namespace App\Repository;

use App\Base\BaseRepository;
use App\Database\DatabaseConnection;

class AdminRepository extends BaseRepository
{

  protected $showableFields = ['admin_id', 'first_name', 'last_name', 'email', 'created_at', 'updated_at'];

  protected $insertableFields = ['first_name', 'last_name', 'email'];

  protected $updatableFields = ['first_name', 'last_name', 'email'];
  protected $columnId = "admin_id";

  function __construct()
  {
    parent::__construct("admin");
  }

  public function loginAdmin($email, $password)
  {
    if ($hashed_password = $this->getColumnValue('password', 'WHERE email = ?', [$email])) {
      if (password_verify($password, $hashed_password)) {
        return $this->fetchByColumn("email", $email);
      }
    }
    return false;
  }

}
