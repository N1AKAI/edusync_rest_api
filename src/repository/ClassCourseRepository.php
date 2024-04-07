<?php

namespace App\Repository;

use App\Database\DatabaseConnection;

class ClassCourseRepository
{
    private $con;
    function __construct()
    {
        $db = new DatabaseConnection;
        $this->con = $db->connect();
    }

    public function createClassCourse($class_id, $course_id)
    {
        $stmt = $this->con->prepare("INSERT INTO class_course (class_id, course_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $class_id, $course_id);
        if ($stmt->execute()) {
            return CLASS_COURSE_CREATED;
        } else {
            return CLASS_COURSE_FAILURE;
        }
    }

    public function getClassCourseById($class_course_id = null)
    {
        $where = "";
        if ($class_course_id) {
            $where = "WHERE class_course_id = ?";
        }
        $stmt = $this->con->prepare("SELECT * FROM class_course $where");
        if ($where != "") {
            $stmt->bind_param("i", $class_course_id);
        }
        $stmt->execute();
        if ($class_course_id) {
            $stmt->bind_result($class_course_id, $class_id, $course_id);
            if ($stmt->fetch()) {
                $class_course = array(
                    'class_course_id' => $class_course_id,
                    'class_id' => $class_id,
                    'course_id' => $course_id
                );
                return $class_course;
            }
            return false;
        } else {
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function updateClassCourse($class_course_id, $class_id, $course_id)
    {
        $stmt = $this->con->prepare("UPDATE class_course SET class_id = ?, course_id = ? WHERE class_course_id = ?");
        $stmt->bind_param("iii", $class_id, $course_id, $class_course_id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        }
        return false;
    }

    public function deleteClassCourse($class_course_id)
    {
        $stmt = $this->con->prepare("DELETE FROM class_course WHERE class_course_id = ?");
        $stmt->bind_param("i", $class_course_id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        }
        return false;
    }
}
