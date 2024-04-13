<?php

namespace App\Repository;

use App\Database\DatabaseConnection;

class QuestionRepository
{
  private $con;
  function __construct()
  {
    $db = new DatabaseConnection;
    $this->con = $db->connect();
  }

  public function getQuestions($test_online_id, $student_id)
  {
    $stmt = $this->con->prepare("SELECT question.question_id, question.question, question.mark, answer.answer, answer.answer_id FROM question
    INNER JOIN test_online USING(test_online_id)
    INNER JOIN answer USING(question_id)
    INNER JOIN class USING(class_id)
    INNER JOIN class_student USING(class_id)
    WHERE test_online.test_online_id = ? AND class_student.student_id = ? ORDER BY question.question, answer.answer_id;
    ");
    $stmt->bind_param("ii", $test_online_id, $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $questions = [];
    while ($row = $result->fetch_assoc()) {
      $questions[] = $row;
    }
    $transformedData = [];
    foreach ($questions as $qa) {
      // Check if the question already exists in $transformedData
      if (isset($transformedData[$qa['question_id']])) {
        // Append the answer to the existing question
        $transformedData[$qa['question_id']]['answers'][] = ['answer_id' => $qa['answer_id'], 'answer' => $qa['answer']];
      } else {
        // Create a new entry for the question with its first answer
        $transformedData[$qa['question_id']] = [
          "question_id" => $qa['question_id'],
          "question" => $qa['question'],
          "mark" => $qa['mark'],
          "answers" => [['answer_id' => $qa['answer_id'], 'answer' => $qa['answer']]]
        ];
      }
    }
    $transformedData = array_values($transformedData);

    return $transformedData;
  }
}
