<?php

namespace App\Repository;

use App\Base\BaseRepository;
use App\Common\JsonResponse;
use App\Database\DatabaseConnection;

class StudentRepository extends BaseRepository
{

  protected $showableFields = ['student_id', 'first_name', 'last_name', 'phone_number', 'fathers_name', 'mothers_name', 'join_date', 'email', "date_of_birth", "gender"];

  protected $insertableFields = ['first_name', 'last_name', 'phone_number', 'fathers_name', 'mothers_name', 'join_date', 'email', "date_of_birth"];

  protected $updatableFields = ['first_name', 'last_name', 'phone_number', 'fathers_name', 'mothers_name', 'join_date', 'email', "date_of_birth"];
  protected $columnId = "student_id";

  function __construct()
  {
    parent::__construct("student");
  }

  public function fetchAll()
  {
    $fields = implode(', ', array_values($this->showableFields));
    $query = "SELECT $fields, cs.class_id, c.class_name FROM {$this->table} INNER JOIN class_student cs USING (student_id) INNER JOIN class c USING (class_id) ORDER BY last_name";
    $stmt = $this->executeQuery($query);

    return $this->getAll($stmt);
  }

  public function createStudent($first_name, $last_name, $phone_number, $fathers_name, $mothers_name, $join_date, $email, $password)
  {
    if (!$this->isEmailExist($email)) {
      $stmt = $this->con->prepare("INSERT INTO student(first_name, last_name,  phone_number,fathers_name, mothers_name, join_date, email, password) VALUES (?,?,?,?,?,?,?,?)");
      $stmt->bind_param("ssssssss", $first_name, $last_name, $phone_number, $fathers_name, $mothers_name, $join_date, $email, $password);
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
  public function getStudentByEmail($email)
  {
    $stmt = $this->con->prepare("SELECT student_id,first_name, last_name,  phone_number,fathers_name, mothers_name, join_date, email,created_at,updated_at
         FROM student WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($student_id, $first_name, $last_name, $phone_number, $fathers_name, $mothers_name, $join_date, $email, $created_at, $updated_at);
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
  public function updateStudent($first_name, $last_name, $phone_number, $fathers_name, $mothers_name, $join_date, $student_id)
  {
    $stmt = $this->con->prepare("UPDATE student SET first_name = ?, last_name = ?, phone_number = ?, fathers_name = ?,mothers_name = ?,join_date = ?, updated_at = CURRENT_TIMESTAMP WHERE
        student_id=?");
    $stmt->bind_param('ssssssi', $first_name, $last_name, $phone_number, $fathers_name, $mothers_name, $join_date, $student_id);
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

  public function getAllClassStudentsHomework($class_id, $homework_id, $teacher_id)
  {
    $stmt = $this->con->prepare("SELECT s.student_id, s.first_name, s.last_name, 
    (SELECT COUNT(*) FROM student s2 
    INNER JOIN class_student cs ON s2.student_id = cs.student_id
    WHERE s2.last_name <= s.last_name
    AND cs.class_id = ?) as position,
    CASE 
        WHEN sh.student_id IS NOT NULL THEN 1
        ELSE 0
    END AS has_homework
    FROM student s
    INNER JOIN class_student cs ON s.student_id = cs.student_id
    INNER JOIN homework h ON cs.class_id = h.class_id
    LEFT JOIN student_homework sh ON s.student_id = sh.student_id AND h.homework_id = sh.homework_id
    WHERE cs.class_id = ? AND h.homework_id = ? AND h.teacher_id = ?");
    $stmt->bind_param("iiii", $class_id, $class_id, $homework_id, $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $students = [];
    while ($row = $result->fetch_assoc()) {
      $students[] = $row;
    }
    return $students;
  }

  public function getClassStudents($id)
  {
    $query = "SELECT student_id, first_name, last_name, date_of_birth,
    phone_number, fathers_name, mothers_name, join_date, email,
    (SELECT COUNT(*) FROM student s2 
    INNER JOIN class_student cs ON s2.student_id = cs.student_id
    WHERE s2.last_name <= s.last_name
    AND cs.class_id = ?) as position
    FROM student s
    INNER JOIN class_student USING (student_id)
    WHERE class_id = ?";
    $params = [$id, $id];
    $stmt = $this->executeQuery($query, $params);
    return $this->getAll($stmt);
  }
}
