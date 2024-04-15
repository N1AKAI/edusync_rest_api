<?php

namespace App\Repository;

use App\Database\DatabaseConnection;

class TestRepository
{

    private $con;
    function __construct()
    {
        $db = new DatabaseConnection;

        $this->con = $db->connect();
    }
    public function createTest($test_code, $mark, $student_id, $course_id)
    {
        if (!$this->isTestCodeExist($test_code)) {
            $stmt = $this->con->prepare("INSERT INTO test (test_code, mark, student_id, course_id) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $test_code, $mark, $student_id, $course_id);
            if ($stmt->execute()) {
                return TEST_CREATED;
            } else {
                return TEST_FAILURE;
            }
        }
        return TEST_EXIST;
    }


    public function getTestById($test_id = null)
    {
        $where = "";
        if ($test_id) {
            $where = "WHERE test_id = ?";
        }
        $stmt = $this->con->prepare("SELECT test_id, test_code, mark, student_id, course_id FROM test $where");
        if ($where != "") {
            $stmt->bind_param("i", $test_id);
        }
        $stmt->execute();
        if ($test_id) {
            $stmt->bind_result($test_id, $test_code, $mark, $student_id, $course_id);
            if ($stmt->fetch()) {
                $test = array(
                    'test_id' => $test_id,
                    'test_code' => $test_code,
                    'mark' => $mark,
                    'student_id' => $student_id,
                    'course_id' => $course_id
                );
                return $test;
            }
            return false;
        } else {
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function updateTest($test_id, $test_code, $mark, $student_id, $course_id)
    {
        $stmt = $this->con->prepare("UPDATE test SET test_code = ?, mark = ?, student_id = ?, course_id = ?, updated_at = CURRENT_TIMESTAMP WHERE test_id = ?");
        $stmt->bind_param("ssssi", $test_code, $mark, $student_id, $course_id, $test_id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        }
        return false;
    }

    public function deleteTest($test_id)
    {
        $stmt = $this->con->prepare("DELETE FROM test WHERE test_id = ?");
        $stmt->bind_param("i", $test_id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        }
        return false;
    }


    private function isTestCodeExist($test_code)
    {
        $stmt = $this->con->prepare("SELECT test_id FROM test WHERE test_code = ?");
        $stmt->bind_param("s", $test_code);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    public function getLatestTestsByStudentEmail($email)
    {
        $stmt = $this->con->prepare("SELECT test_id, test_code, mark, course_name,
        course_code, test.created_at
        FROM test INNER JOIN student USING (student_id)
        INNER JOIN course USING (course_id) WHERE email = ? ORDER BY test_id DESC");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $tests = [];
        while ($row = $result->fetch_assoc()) {
            $tests[] = $row;
        }
        return $tests;
    }
}
