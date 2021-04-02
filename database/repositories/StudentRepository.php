<?php

namespace database\repositories;

use database\repositories\Repository;
use app\models\Student;

class StudentRepository extends Repository {

    public function getAll() {
        $sql = "SELECT * FROM student";
        $stmt = $this->conn->query( $sql );
        $stmt->setFetchMode( \PDO::FETCH_CLASS, Student::class );
        $students = $stmt->fetchAll();
        return $students;
    }



}