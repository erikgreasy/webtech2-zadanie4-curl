<?php

namespace database;

class Database {
    private $host = DB_HOST;
    private $name = DB_NAME;
    private $username = DB_USER;
    private $password = DB_PASS;

    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->connection = new \PDO("mysql:host=" . $this->host . ";dbname=" . $this->name, $this->username, $this->password);
            $this->connection->exec("set names utf8");
        } catch( PDOException $exception ) {
            echo "Database could not be connected: " . $exception->getMessage();
        }

        return $this->connection;
    }

}