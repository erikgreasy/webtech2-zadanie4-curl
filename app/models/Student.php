<?php

namespace app\models;

use database\repositories\LogRepository;
use database\repositories\LectureRepository;
use database\repositories\StudentRepository;

class Student implements \JsonSerializable {

    private $id;
    private $name;
    private $timeOnLectures;
    private $logs;

    
    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function timeOnLecture( $lecture ) {
        
        $lectureLogs = [];
        foreach( $this->logs as $log ) {
            if( $log->lecture_id == $lecture->getId() ) {
                $lectureLogs[] = $log;
            }
        }


        $totalTime = 0;

        if( $lectureLogs ) {
            $joined = false;
            $left = false;
            
            foreach( $lectureLogs as $index => $log ) {
                if( $index%2 == 0 ) {
                    $joined = $log->getTime();
                } else {
                    $left = $log->getTime();
                    $totalTime += strtotime($left) - strtotime($joined);
                }

            }

            if( $joined && !$left ) {
                $totalTime += strtotime( $lecture->endTime() ) - strtotime( $joined );
            }

            $totalTime = intVal( $totalTime / 60 );

            $this->timeOnLectures[$lecture->getId()] = $totalTime;

            return $totalTime;
        }

        return 0;
    }

    public function totalLectures() {
        // $lr = new LectureRepository();

        $attendedLectures = [];

        foreach( $this->logs as $log) {
            if( !in_array( $log->lecture_id, $attendedLectures ) ) {
                $attendedLectures[] = $log->lecture_id;
            }
        }


        return count($attendedLectures);
    }

    public function timeOnLectures() {
        
        $totalTime = 0;
        
        foreach( $this->timeOnLectures as $lecture ) {
            $totalTime += $lecture;
        }

        return $totalTime;
    }


    public function jsonSerialize()
    {
        return 
        [
            'id'   => $this->getId(),
            'name' => $this->getName()
        ];
    }

    /**
     * Get the value of logs
     */ 
    public function getLogs()
    {
        return $this->logs;
    }

    /**
     * Set the value of logs
     *
     * @return  self
     */ 
    public function setLogs($logs)
    {
        $this->logs = $logs;

        return $this;
    }
}