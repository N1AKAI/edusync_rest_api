<?php

namespace App\Repository;

use App\Database\DatabaseConnection;

class TeacherRepository
{

  private $con;
  function __construct()
  {
    $db = new DatabaseConnection;
    $this->con = $db->connect();
  }
  public function createteacher($first_name, $last_name, $email, $password, $phone_number)
  {
    if (!$this->isEmailExist($email)) {
      $stmt = $this->con->prepare("INSERT INTO teacher(first_name, last_name, email, password, phone_number) VALUES (?,?,?,?,?)");
      $stmt->bind_param("sssss", $first_name, $last_name, $email, $password, $phone_number);
      if ($stmt->execute()) {
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
    $stmt = $this->con->prepare("SELECT password FROM teacher WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($password);
    $stmt->fetch();
    return $password;
  }
  public function getAllTeachers()
  {
    $stmt = $this->con->prepare("SELECT teacher_id,first_name,last_name ,email ,phone_number ,created_at,updated_at
        FROM teacher;");
    $stmt->execute();
    $stmt->bind_result($teacher_id, $first_name, $last_name, $email, $phone_number, $created_at, $updated_at);
    $teachers = array();
    while ($stmt->fetch()) {;
      $teacher = array();
      $teacher['teacher_id'] = $teacher_id;
      $teacher['first_name'] = $first_name;
      $teacher['last_name'] = $last_name;
      $teacher['email'] = $email;
      $teacher['phone_number'] = $phone_number;
      $teacher['created_at'] = $created_at;
      $teacher['updated_at'] = $updated_at;
      array_push($teachers, $teacher);
    }
    return $teachers;
  }
  public function getTeacherByEmail($email)
  {
    $stmt = $this->con->prepare("SELECT teacher_id,first_name,last_name ,email ,phone_number ,created_at,updated_at
         FROM teacher WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($teacher_id, $first_name, $last_name, $email, $phone_number, $created_at, $updated_at);
    $stmt->fetch();
    $teacher = array();
    $teacher['teacher_id'] = $teacher_id;
    $teacher['first_name'] = $first_name;
    $teacher['last_name'] = $last_name;
    $teacher['email'] = $email;
    $teacher['phone_number'] = $phone_number;
    $teacher['created_at'] = $created_at;
    $teacher['updated_at'] = $updated_at;
    return $teacher;
  }
  public function updateTeacher($first_name, $last_name, $email, $phone_number, $teacher_id)
  {
    $stmt = $this->con->prepare("UPDATE teacher SET first_name = ?, last_name = ?, email = ?, phone_number = ?, updated_at = CURRENT_TIMESTAMP WHERE
        teacher_id=?");
    $stmt->bind_param('ssssi', $first_name, $last_name, $email, $phone_number, $teacher_id);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
      return true;
    }
    return false;
  }

  public function updatePassword($currentpassword, $newpassword, $email)
  {
    $hashed_password = $this->getTeacherPasswordByEmail($email);
    if (password_verify($currentpassword, $hashed_password)) {
      $hash_password = password_hash($newpassword, PASSWORD_DEFAULT);
      $stmt = $this->con->prepare("UPDATE teacher SET password = ? WHERE email = ?");
      $stmt->bind_param('ss', $hash_password, $email);
      $stmt->execute();
      if ($stmt->affected_rows > 0) {
        return PASSWORD_CHANGED;
      }
      return PASSWORD_NOT_CHANGED;
    } else {
      return PASSWORD_DO_NOT_MATCH;
    }
  }

  public function deleteTeacher($teacher_id)
  {
    $stmt = $this->con->prepare("DELETE FROM teacher WHERE teacher_id=?");
    $stmt->bind_param("i", $teacher_id);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
      return true;
    }
    return false;
  }
  private function isEmailExist($email)
  {
    $stmt = $this->con->prepare("SELECT teacher_id FROM teacher WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows > 0;
  }

  public function getTeacherAndTheirClassesByEmail($email)
  {
    $stmt = $this->con->prepare("SELECT teacher_id, first_name, last_name, email,
    phone_number, date_of_birth, GROUP_CONCAT(class_teacher.class_id) AS class_ids
    FROM teacher
    INNER JOIN class_teacher USING(teacher_id)
    WHERE teacher.email = ?");

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $row['class_ids'] = explode(",", $row['class_ids']);
    return $row;
  }
}
