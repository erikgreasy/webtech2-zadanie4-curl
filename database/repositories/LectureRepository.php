<?php

namespace database\repositories;

use app\models\Lecture;
use app\models\repositories;

class LectureRepository extends Repository {


    public function get( $id ) {
        $sql = "SELECT * FROM lecture WHERE id = :id";
        $stmt = $this->conn->prepare( $sql );
        $stmt->setFetchMode( \PDO::FETCH_CLASS, Lecture::class );
        $stmt->execute([
            'id'    => $id
        ]);

        $lecture = $stmt->fetch();

        if( $lecture ) {
            return $lecture;
        }

        return false;
    }

    public function getAll() {
        $sql = "SELECT * FROM lecture";
        $stmt = $this->conn->query($sql);
        $stmt->setFetchMode( \PDO::FETCH_CLASS, Lecture::class );
        $lectures = $stmt->fetchAll();
        return $lectures;
    }

    public function add( $lecture ) {
        $sql = "INSERT INTO lecture (date, file_id) VALUES(:date, :file_id)";
        $stmt = $this->conn->prepare( $sql );
        $stmt->execute([
            'date'      => $lecture->getDate(),
            'file_id'   => $lecture->getFile()->getId(),

        ]);
        if( $stmt ) {
            $insertedLecture = $this->get( $this->conn->lastInsertId() );
            return $insertedLecture;
        }

        return false;

    } 

    public function addAll( $lectures ) {
        $sql = "INSERT INTO lecture() VALUES";
        $sql .= str_repeat( "(), ", count($lectures) - 1 );
        $sql .= "()";
        $stmt = $this->conn->prepare( $sql );
        return $stmt->execute();

    }

    public function getLectureEndTime( $lecture ) {
        $sql = "SELECT time FROM log WHERE lecture_id = :lecture_id ORDER BY time DESC LIMIT 1";
        $stmt = $this->conn->prepare( $sql );
        $stmt->execute([
            'lecture_id'    => $lecture->getId()
        ]);

        $time = $stmt->fetch(\PDO::FETCH_COLUMN);

        return $time;
    }


    public function getNumberOfStudents( $lecture ) {
        $sql = "SELECT COUNT(DISTINCT(log.student_id)) FROM lecture
        LEFT JOIN log ON log.lecture_id = lecture.id
        WHERE lecture.id = :lecture_id
        GROUP BY lecture.id";
        $stmt = $this->conn->prepare( $sql );
        $stmt->execute([
            'lecture_id'    => $lecture->getId()
        ]);
        $num = $stmt->fetch(\PDO::FETCH_COLUMN);
        return $num;
    }


}