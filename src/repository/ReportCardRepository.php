<?php

namespace App\Repository;

use App\Database\DatabaseConnection;

class ReportCardRepository
{
    private $con;

    function __construct()
    {
        $db = new DatabaseConnection;
        $this->con = $db->connect();
    }

    public function createReportCard($student_id, $teacher_remark, $teacher_id)
    {
        $stmt = $this->con->prepare("INSERT INTO report_card (student_id, teacher_remark, teacher_id) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $student_id, $teacher_remark, $teacher_id);
        if ($stmt->execute()) {
            return REPORT_CARD_CREATED;
        } else {
            return REPORT_CARD_FAILURE;
        }
    }

    public function getReportCardById($report_card_id = null)
    {
        $where = "";
        if ($report_card_id) {
            $where = "WHERE report_card_id = ?";
        }
        $stmt = $this->con->prepare("SELECT * FROM report_card $where");
        if ($where != "") {
            $stmt->bind_param("i", $report_card_id);
        }
        $stmt->execute();
        if ($report_card_id) {
            $stmt->bind_result($report_card_id, $student_id, $teacher_remark, $teacher_id);
            if ($stmt->fetch()) {
                $report_card = array(
                    'report_card_id' => $report_card_id,
                    'student_id' => $student_id,
                    'teacher_remark' => $teacher_remark,
                    'teacher_id' => $teacher_id
                );
                return $report_card;
            }
            return false;
        } else {
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function updateReportCard($report_card_id, $student_id, $teacher_remark, $teacher_id)
    {
        $stmt = $this->con->prepare("UPDATE report_card SET student_id = ?, teacher_remark = ?, teacher_id = ? WHERE report_card_id = ?");
        $stmt->bind_param("issi", $student_id, $teacher_remark, $teacher_id, $report_card_id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        }
        return false;
    }

    public function deleteReportCard($report_card_id)
    {
        $stmt = $this->con->prepare("DELETE FROM report_card WHERE report_card_id = ?");
        $stmt->bind_param("i", $report_card_id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        }
        return false;
    }
}
?>
