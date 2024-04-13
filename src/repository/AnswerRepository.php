<?php

namespace App\Repository;

use App\Database\DatabaseConnection;

class AnswerRepository
{
    private $con;
    function __construct()
    {
        $db = new DatabaseConnection;
        $this->con = $db->connect();
    }
    public function createAnswer($is_correct, $question_id)
    {
        $stmt = $this->con->prepare("INSERT INTO answer (is_correct, question_id) VALUES (?, ?)");
        $stmt->bind_param("si", $is_correct, $question_id);
        if ($stmt->execute()) {
            return ANSWER_CREATED;
        } else {
            return ANSWER_FAILURE;
        }
    }

    public function getAnswerById($answer_id = null)
    {
        $where = "";
        if ($answer_id) {
            $where = "WHERE answer_id = ?";
        }
        $stmt = $this->con->prepare("SELECT answer_id, is_correct, question_id FROM answer $where");
        if ($where != "") {
            $stmt->bind_param("i", $answer_id);
        }
        $stmt->execute();
        if ($answer_id) {
            $stmt->bind_result($answer_id, $is_correct, $question_id);
            if ($stmt->fetch()) {
                $answer = array(
                    'answer_id' => $answer_id,
                    'is_correct' => $is_correct,
                    'question_id' => $question_id
                );
                return $answer;
            }
            return false;
        } else {
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function updateAnswer($answer_id, $is_correct, $question_id)
    {
        $stmt = $this->con->prepare("UPDATE answer SET is_correct = ?, question_id = ? WHERE answer_id = ?");
        $stmt->bind_param("sii", $is_correct, $question_id, $answer_id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        }
        return false;
    }

    public function deleteAnswer($answer_id)
    {
        $stmt = $this->con->prepare("DELETE FROM answer WHERE answer_id = ?");
        $stmt->bind_param("i", $answer_id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        }
        return false;
    }

    public function isAnswerCorrect($question_id, $answer_id)
    {
        $stmt = $this->con->prepare("SELECT mark FROM answer
        INNER JOIN question USING (question_id)
        WHERE question_id = ? AND answer_id = ? AND is_correct = 1");
        $stmt->bind_param("ii", $question_id, $answer_id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($mark);
        $stmt->fetch();
        return $mark;
    }
}
