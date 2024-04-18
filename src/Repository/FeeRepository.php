<?php

namespace App\Repository;

use App\Base\BaseRepository;
use App\Database\DatabaseConnection;

class FeeRepository extends BaseRepository
{
    protected $showableFields = ['fee_id', 'student_id', 'fee_description', 'total_fee', 'fee_date', 'is_paid'];

    protected $insertableFields = ['student_id', 'fee_description', 'total_fee', 'fee_date', 'is_paid'];

    protected $updatableFields = ['student_id', 'fee_description', 'total_fee', 'fee_date', 'is_paid'];
    protected $columnId = "class_id";
    function __construct()
    {
        parent::__construct('fee');
    }

    public function createFee($student_id, $fee_description, $total_fee, $fee_date, $is_paid)
    {
        $stmt = $this->con->prepare("INSERT INTO fee (student_id, fee_description, total_fee, fee_date, is_paid) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issis", $student_id, $fee_description, $total_fee, $fee_date, $is_paid);
        if ($stmt->execute()) {
            return FEE_CREATED;
        } else {
            return FEE_FAILURE;
        }
    }

    public function getFeeById($fee_id = null)
    {
        $where = "";
        if ($fee_id) {
            $where = "WHERE fee_id = ?";
        }
        $stmt = $this->con->prepare("SELECT * FROM fee $where");
        if ($where != "") {
            $stmt->bind_param("i", $fee_id);
        }
        $stmt->execute();
        if ($fee_id) {
            $stmt->bind_result($fee_id, $student_id, $fee_description, $total_fee, $fee_date, $is_paid);
            if ($stmt->fetch()) {
                $fee = array(
                    'fee_id' => $fee_id,
                    'student_id' => $student_id,
                    'fee_description' => $fee_description,
                    'total_fee' => $total_fee,
                    'fee_date' => $fee_date,
                    'is_paid' => $is_paid
                );
                return $fee;
            }
            return false;
        } else {
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function updateFee($fee_id, $student_id, $fee_description, $total_fee, $fee_date, $is_paid)
    {
        $stmt = $this->con->prepare("UPDATE fee SET student_id = ?, fee_description = ?, total_fee = ?, fee_date = ?, is_paid = ? WHERE fee_id = ?");
        $stmt->bind_param("issisi", $student_id, $fee_description, $total_fee, $fee_date, $is_paid, $fee_id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        }
        return false;
    }

    public function deleteFee($fee_id)
    {
        $stmt = $this->con->prepare("DELETE FROM fee WHERE fee_id = ?");
        $stmt->bind_param("i", $fee_id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        }
        return false;
    }

    public function getStudentsFees($student_id)
    {
        $stmt = $this->con->prepare("SELECT * FROM fee WHERE student_id = ? ORDER BY fee_date DESC");
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $fees = [];
        while ($row = $result->fetch_assoc()) {
            $fees[] = $row;
        }
        return $fees;
    }

    public function totalRevenue()
    {
        $query = "SELECT SUM(total_fee) as revenue FROM `fee` WHERE is_paid = 1";
        $stmt = $this->executeQuery($query);
        return $stmt->get_result()->fetch_assoc()['revenue'];
    }
}
