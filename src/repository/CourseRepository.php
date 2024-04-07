<?php

namespace App\Repository;

use App\Database\DatabaseConnection;

class CourseRepository
{
  private $con;
  function __construct()
  {
    $db = new DatabaseConnection;
    $this->con = $db->connect();
  }
  public function createCourse($course_name, $course_code)
  {
    $stmt = $this->con->prepare("INSERT INTO course (course_name, course_code) VALUES (?, ?)");
    $stmt->bind_param("ss", $course_name, $course_code);
    if ($stmt->execute()) {
      return COURSE_CREATED;
    } else {
      return COURSE_FAILUARE;
    }
  }

  public function getCourseById($course_id = null)
  {
    $where = "";
    if ($course_id) {
      $where = "WHERE crouse_id = ?";
    }
    $stmt = $this->con->prepare("SELECT * FROM course $where");
    if ($where != "") {
      $stmt->bind_param("i", $course_id);
    }
    $stmt->execute();
    if ($course_id) {
      $stmt->bind_result($course_id, $course_name, $course_code, $created_at, $updated_at);
      if ($stmt->fetch()) {
        $course = array(
          'crouse_id' => $course_id,
          'course_name' => $course_name,
          'course_code' => $course_code,
          'updated_at' => $updated_at
        );
        return $course;
      }
      return false;
    }
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
  }

  public function updateCourse($course_name, $course_code, $course_id)
  {

    $stmt = $this->con->prepare("UPDATE course SET course_name = ?, course_code = ?, updated_at = CURRENT_TIMESTAMP WHERE crouse_id = ?");
    $stmt->bind_param("ssi", $course_name, $course_code, $course_id);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
      return true;
    }
    return false;
  }

  public function deleteCourse($course_id)
  {
    $stmt = $this->con->prepare("DELETE FROM course WHERE crouse_id = ?");
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
      return true;
    }
    return false;
  }
}
