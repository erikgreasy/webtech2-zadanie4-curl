<?php

namespace database\repositories;

use app\models\Log;
use app\models\Student;
use database\repositories\Repository;

class StudentRepository extends Repository {


    public function get( $id ) {
        $sql = "SELECT * FROM student WHERE id = :id";
        $stmt = $this->conn->prepare( $sql );
        $stmt->setFetchMode( \PDO::FETCH_CLASS, Student::class );
        $stmt->execute([
            'id'    => $id
        ]);

        $user = $stmt->fetch();

        if( $user ) {
            return $user;
        }

        return false;
    }


    public function getAll($orderBy = '', $order = '') {
        $sql = "SELECT id, name, SUBSTRING_INDEX(student.name, ' ', -1) as surname FROM `student`";
        
        if( $orderBy != '' ) {
            switch( $orderBy ) {
                case 'student':
                    $orderBy = " surname";
                    break;
                default:
                    redirect(BASE_URL);
                    break;
            }

            $sql .= " ORDER BY $orderBy";

            if( $order != '' ) {
                $sql .= " $order";
            }
        }
        $stmt = $this->conn->query( $sql );
        $stmt->setFetchMode( \PDO::FETCH_CLASS, Student::class );

        $students = $stmt->fetchAll();

        foreach( $students as $student ) {
            $sql = "SELECT * FROM log WHERE student_id = :student_id";
            
            $stmt = $this->conn->prepare( $sql );
            $stmt->setFetchMode( \PDO::FETCH_CLASS, Log::class );
            $stmt->execute([
                'student_id'       => $student->getId(),
            ]);
            $logs = $stmt->fetchAll();
            $student->setLogs( $logs );
        }
        

        return $students;
    }


    public function getByName( $name ) {
        $sql = "SELECT * FROM student WHERE name = :name";
        $stmt = $this->conn->prepare( $sql );
        $stmt->setFetchMode( \PDO::FETCH_CLASS, Student::class );
        $stmt->execute([
            'name'  => $name
        ]);

        $user = $stmt->fetch();
        if( $user ) {
            return $user;
        }

        return false;
    }

    public function add( $student ) {
        $sql = "INSERT INTO student (name) VALUES(:name)";
        $stmt = $this->conn->prepare( $sql );
        $stmt->execute([
            'name'  => $student->getName()
        ]);

        $insertedUser = $this->get( $this->conn->lastInsertId() );

        return $insertedUser;
    }



}