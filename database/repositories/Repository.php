<?php

namespace database\repositories;

use database\Database;

class Repository {

    protected $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }


}