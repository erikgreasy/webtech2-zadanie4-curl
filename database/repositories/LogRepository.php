<?php

namespace database\repositories;

use app\models\Log;
use app\models\repositories;

class LogRepository extends Repository {


    public function get( $id ) {
        $sql = "SELECT * FROM log WHERE id = :id";
        $stmt = $this->conn->prepare( $sql );
        $stmt->setFetchMode( \PDO::FETCH_CLASS, Log::class );
        $stmt->execute([
            'id'    => $id
        ]);

        $log = $stmt->fetch();

        if( $log ) {
            return $log;
        }

        return false;
    }

    public function getAll() {
        $sql = "SELECT * FROM log";
        $stmt = $this->conn->query($sql);
        $stmt->setFetchMode( \PDO::FETCH_CLASS, Log::class );
        $logs = $stmt->fetchAll();
        return $logs;
    }

    public function add( $log ) {
        $sql = "INSERT INTO log (status, time, lecture_id, student_id) VALUES(:status, :time, :lecture_id, :student_id)";
        $stmt = $this->conn->prepare( $sql );
        $stmt->execute([
            'status'    => $log->getStatus(),
            'time'      => $log->getTime(),
            'lecture_id'=> $log->getLecture()->getId(),
            'student_id'=> $log->getStudent()->getId()
        ]);

        if( $stmt ) {
            $insertedLog = $this->get( $this->conn->lastInsertId() );
            return $insertedLog;
        }

        return false;

    } 


    public function getByUserLecture( $student_id, $lecture_id ) {
        $sql = "SELECT * FROM log WHERE student_id = :student_id AND lecture_id = :lecture_id";
        $stmt = $this->conn->prepare( $sql );
        $stmt->setFetchMode( \PDO::FETCH_CLASS, Log::class );
        $stmt->execute([
            'student_id'       => $student_id,
            'lecture_id'    => $lecture_id,
        ]);
        $logs = $stmt->fetchAll();

        if( $logs ) {
            return $logs;
        }

        return false;
    }


}