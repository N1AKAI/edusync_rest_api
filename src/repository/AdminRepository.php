<?php

namespace App\Repository;

use App\Database\DatabaseConnection;

class AdminRepository
{

  private $con;
  function __construct()
  {
    $db = new DatabaseConnection();
    $this->con = $db->connect();
  }

  public function loginAdmin($email, $password)
  {
    if ($hashed_password = $this->getAdminPassword($email)) {
      if (password_verify($password, $hashed_password)) {
        return $this->getAdmin($email);
      }
    }
    return false;
  }

  public function getAdmin($email)
  {
    $stmt = $this->con->prepare("SELECT admin_id, first_name, last_name, email, created_at, updated_at FROM admin WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
  }

  public function getAdminPassword($email) {
    $stmt = $this->con->prepare("SELECT password FROM admin WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($password);
    $stmt->fetch();
    return $password;
  }
}
