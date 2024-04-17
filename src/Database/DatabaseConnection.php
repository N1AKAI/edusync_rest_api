<?php

namespace App\Database;

use mysqli;

class DatabaseConnection
{
    private $con;
    function connect()
    {
        $this->con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if (mysqli_connect_errno()) {
            echo "Failed to connect " . mysqli_connect_error();
            return null;
        }
        $this->con->set_charset("utf8");
        return $this->con;
    }
}
