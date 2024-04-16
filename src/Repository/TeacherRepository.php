<?php

namespace App\Repository;

use App\Base\BaseRepository;

class TeacherRepository extends BaseRepository
{

  protected $showableFields = ['teacher_id', 'first_name', 'last_name', 'email', 'phone_number', 'gender', 'date_of_birth', 'joining_date', 'qualification', 'experience', 'cne', 'adresse', 'city', 'state', 'zip_code', 'created_at', 'updated_at'];

  protected $insertableFields = ['first_name', 'last_name', 'email', 'password', 'phone_number', 'gender', 'date_of_birth', 'joining_date', 'qualification', 'experience', 'cne', 'adresse', 'city', 'state', 'zip_code'];

  protected $updatableFields = ['first_name', 'last_name', 'email', 'phone_number', 'gender', 'date_of_birth', 'joining_date', 'qualification', 'experience', 'cne', 'adresse', 'city', 'state', 'zip_code'];
  protected $columnId = "teacher_id";

  public function __construct()
  {
    parent::__construct("teacher");
  }

  public function create($data, $passwordField = "")
  {
    if (!$this->isEmailExist($data["email"])) {
      if (parent::create($data, $passwordField)) {
        return TEACHER_CREATED;
      } else {
        return TEACHER_FAILUARE;
      }
    }
    return TEACHER_EXIST;
  }

  public function teacherLogin($email, $password)
  {
    if ($this->isEmailExist($email)) {
      $hashed_password = $this->getTeacherPasswordByEmail($email);
      if (password_verify($password, $hashed_password)) {
        return TEACHER_AUTHENTICATED;
      } else {
        return TEACHER_PASSWORD_DO_NOT_MATCH;
      }
    } else {
      return TEACHER_NOT_FOUND;
    }
  }
  private function getTeacherPasswordByEmail($email)
  {
    return $this->getColumnValue('password', 'WHERE email = ?', [$email]);
  }

  public function updatePassword($currentpassword, $newpassword, $email)
  {
    $hashed_password = $this->getTeacherPasswordByEmail($email);
    if (password_verify($currentpassword, $hashed_password)) {
      $hash_password = password_hash($newpassword, PASSWORD_DEFAULT);
      $query = "UPDATE teacher SET password = ? WHERE email = ?";
      $params = [$hash_password, $email];
      $stmt = $this->executeQuery($query, $params);
      if ($stmt->affected_rows > 0) {
        return PASSWORD_CHANGED;
      }
      return PASSWORD_NOT_CHANGED;
    } else {
      return PASSWORD_DO_NOT_MATCH;
    }
  }


  public function isEmailExist($email)
  {
    $stmt = $this->executeQuery("SELECT teacher_id FROM teacher WHERE email = ?", [$email]);
    return $stmt->fetch();
  }

  public function getTeacherAndTheirClassesByEmail($email)
  {
    $stmt = $this->executeQuery("SELECT teacher_id, first_name, last_name, email,
    phone_number, date_of_birth, GROUP_CONCAT(class_teacher.class_id) AS class_ids
    FROM teacher
    INNER JOIN class_teacher USING(teacher_id)
    WHERE teacher.email = ?", [$email]);
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $row['class_ids'] = explode(",", $row['class_ids']);
    return $row;
  }
}
