<?php

namespace App\Repository;

use App\Database\DatabaseConnection;

class HolidayRepository
{
    private $con;
    function __construct()
    {
        $db = new DatabaseConnection;
        $this->con = $db->connect();
    }

    public function createHoliday($date)
    {
        $stmt = $this->con->prepare("INSERT INTO holiday (date) VALUES (?)");
        $stmt->bind_param("s", $date);
        if ($stmt->execute()) {
            return HOLIDAY_CREATED;
        } else {
            return HOLIDAY_FAILURE;
        }
    }

    public function getHolidayById($holiday_id = null)
    {
        $where = "";
        if ($holiday_id) {
            $where = "WHERE holiday_id = ?";
        }
        $stmt = $this->con->prepare("SELECT * FROM holiday $where");
        if ($where != "") {
            $stmt->bind_param("i", $holiday_id);
        }
        $stmt->execute();
        if ($holiday_id) {
            $stmt->bind_result($holiday_id, $date);
            if ($stmt->fetch()) {
                $holiday = array(
                    'holiday_id' => $holiday_id,
                    'date' => $date
                );
                return $holiday;
            }
            return false;
        } else {
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function updateHoliday($holiday_id, $date)
    {
        $stmt = $this->con->prepare("UPDATE holiday SET date = ? WHERE holiday_id = ?");
        $stmt->bind_param("si", $date, $holiday_id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        }
        return false;
    }

    public function deleteHoliday($holiday_id)
    {
        $stmt = $this->con->prepare("DELETE FROM holiday WHERE holiday_id = ?");
        $stmt->bind_param("i", $holiday_id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        }
        return false;
    }
}
