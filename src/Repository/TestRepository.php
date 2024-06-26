<?php

namespace App\Repository;

use App\Base\BaseRepository;
use App\Database\DatabaseConnection;

class TestRepository extends BaseRepository
{
    protected $showableFields = ['test_id', 'test_code', 'mark', 'student_id', 'course_id', 'created_at', 'updated_at'];

    protected $insertableFields = ['test_code', 'mark', 'student_id', 'course_id'];

    protected $updatableFields = ['test_code', 'mark', 'student_id', 'course_id'];
    protected $columnId = "test_id";

    function __construct()
    {
        parent::__construct("test");
    }

    public function update($id, $data, $passwordField = "")
    {
        $query = "UPDATE {$this->table} SET mark = ? WHERE {$this->columnId} = ?";
        $stmt = $this->executeQuery($query, [$data, $id]);

        return $stmt->affected_rows > 0;
    }


    public function getClassMarks($params)
    {
        $query = "SELECT student_id,
        GROUP_CONCAT(test_id SEPARATOR ',') AS test_ids,
        GROUP_CONCAT(CONCAT(test_code, ':', mark) SEPARATOR ',') AS test_marks
        FROM test
        INNER JOIN class_student USING (student_id)
        WHERE course_id = ? AND class_id = ?
        GROUP BY student_id";
        $stmt = $this->executeQuery($query, $params);
        return $this->getAll($stmt);
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
