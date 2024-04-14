<?php

namespace App\Repository;

use App\Database\DatabaseConnection;

class StudentRepository
{

  private $con;
  function __construct()
  {
    $db = new DatabaseConnection;
    $this->con = $db->connect();
  }
  public function createStudent($first_name, $last_name,  $phone_number,  $fathers_name, $mothers_name, $join_date, $email, $password)
  {
    if (!$this->isEmailExist($email)) {
      $stmt = $this->con->prepare("INSERT INTO student(first_name, last_name,  phone_number,fathers_name, mothers_name, join_date, email, password) VALUES (?,?,?,?,?,?,?,?)");
      $stmt->bind_param("ssssssss", $first_name, $last_name,  $phone_number,  $fathers_name, $mothers_name, $join_date, $email, $password);
      if ($stmt->execute()) {
        return STUDENT_CREATED;
      } else {
        return STUDENT_FAILUARE;
      }
    }
    return STUDENT_EXIST;
  }

  public function studentLogin($email, $password)
  {
    if ($this->isEmailExist($email)) {
      $hashed_password = $this->getStudentPasswordByEmail($email);
      if (password_verify($password, $hashed_password)) {
        return STUDENT_AUTHENTICATED;
      } else {
        return STUDENT_PASSWORD_DO_NOT_MATCH;
      }
    } else {
      return STUDENT_NOT_FOUND;
    }
  }

  private function getStudentPasswordByEmail($email)
  {
    $stmt = $this->con->prepare("SELECT password FROM student WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($password);
    $stmt->fetch();
    return $password;
  }

  public function getAllStudent()
  {
    $stmt = $this->con->prepare("SELECT student_id,first_name, last_name,  phone_number,fathers_name, mothers_name, join_date, email,created_at,updated_at
        FROM student;");
    $stmt->execute();
    $stmt->bind_result($student_id, $first_name, $last_name,  $phone_number, $fathers_name, $mothers_name, $join_date, $email, $created_at, $updated_at);
    $students = array();
    while ($stmt->fetch()) {;
      $student = array();
      $student['student_id'] = $student_id;
      $student['first_name'] = $first_name;
      $student['last_name'] = $last_name;
      $student['phone_number'] = $phone_number;
      $student['fathers_name'] = $fathers_name;
      $student['mothers_name'] = $mothers_name;
      $student['join_date'] = $join_date;
      $student['email'] = $email;
      $student['created_at'] = $created_at;
      $student['updated_at'] = $updated_at;
      array_push($students, $student);
    }
    return $students;
  }
  public function getStudentByEmail($email)
  {
    $stmt = $this->con->prepare("SELECT student_id,first_name, last_name,  phone_number,fathers_name, mothers_name, join_date, email,created_at,updated_at
         FROM student WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($student_id, $first_name, $last_name,  $phone_number, $fathers_name, $mothers_name, $join_date, $email, $created_at, $updated_at);
    $stmt->fetch();
    $student = array();
    $student['student_id'] = $student_id;
    $student['first_name'] = $first_name;
    $student['last_name'] = $last_name;
    $student['phone_number'] = $phone_number;
    $student['fathers_name'] = $fathers_name;
    $student['mothers_name'] = $mothers_name;
    $student['join_date'] = $join_date;
    $student['email'] = $email;
    $student['created_at'] = $created_at;
    $student['updated_at'] = $updated_at;
    return $student;
  }
  public function updateStudent($first_name, $last_name,  $phone_number, $fathers_name, $mothers_name, $join_date, $student_id)
  {
    $stmt = $this->con->prepare("UPDATE student SET first_name = ?, last_name = ?, phone_number = ?, fathers_name = ?,mothers_name = ?,join_date = ?, updated_at = CURRENT_TIMESTAMP WHERE
        student_id=?");
    $stmt->bind_param('ssssssi', $first_name, $last_name,  $phone_number, $fathers_name, $mothers_name, $join_date, $student_id);
    $stmt->execute();
    if ($stmt->affected_rows) {
      return true;
    }
    return false;
  }

  public function updatePasswordStudnt($currentpassword, $newpassword, $email)
  {
    $hashed_password = $this->getStudentPasswordByEmail($email);
    if (password_verify($currentpassword, $hashed_password)) {
      $hash_password = password_hash($newpassword, PASSWORD_DEFAULT);
      $stmt = $this->con->prepare("UPDATE student SET password = ? WHERE email = ?");
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

  public function deleteStudent($student_id)
  {
    $stmt = $this->con->prepare("DELETE FROM student WHERE student_id=?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
      return true;
    }
    return false;
  }

  public function isEmailExist($email)
  {
    $stmt = $this->con->prepare("SELECT student_id FROM student WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows > 0;
  }

  public function addOtp($otp, $email)
  {
    $stmt = $this->con->prepare("UPDATE student SET otp = ? WHERE email = ?");
    $encoded_otp = base64_encode($otp);
    $stmt->bind_param("ss", $encoded_otp, $email);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
      return true;
    }
    return false;
  }

  public function isValidOtp($otp, $email)
  {
    $stmt = $this->con->prepare("SELECT student_id FROM student WHERE email = ? AND otp = ?");
    $encoded_otp = base64_encode($otp);
    $stmt->bind_param("ss", $email, $encoded_otp);
    $stmt->execute();
    if ($stmt->fetch()) {
      return true;
    }
    return false;
  }

  public function changePassword($password, $email)
  {
    $stmt = $this->con->prepare("UPDATE student SET password = ?, otp = null WHERE email = ?");
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt->bind_param("ss", $hashed_password, $email);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
      return true;
    }
    return false;
  }

  public function getStudentAndTheirClassByEmail($email)
  {
    $stmt = $this->con->prepare("SELECT class_id,
    student_id, first_name, last_name, phone_number,
    fathers_name, mothers_name, join_date, email, avatar,
    class_name, class_year, date_of_birth
    FROM student  INNER JOIN class_student
    USING(student_id) INNER JOIN class
    using(class_id) WHERE student.email = ?
    ORDER BY class_year DESC");

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
  }
}
