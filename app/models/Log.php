<?php

namespace app\models;


class Log implements \JsonSerializable {
    private $id;
    private $status;
    private $time;
    private $lecture;
    private $student;


    
    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of time
     */ 
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set the value of time
     *
     * @return  self
     */ 
    public function setTime($time)
    {
        $time = explode( ',', $time );
        if( ! strtotime( $time[0] ) ) {
            $newTime = date( 'Y-m-d ', strtotime( str_replace( '/', '-',$time[0] ) ) );
        } else {
            $newTime = date( 'Y-m-d ', strtotime( $time[0] ) );
        }
        $newTime .= date( 'H-i-s', strtotime( $time[1] ) );
        $this->time = $newTime;

        return $this;
    }

    /**
     * Get the value of lecture
     */ 
    public function getLecture()
    {
        return $this->lecture;
    }

    /**
     * Set the value of lecture
     *
     * @return  self
     */ 
    public function setLecture($lecture)
    {
        $this->lecture = $lecture;

        return $this;
    }

    /**
     * Get the value of student
     */ 
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * Set the value of student
     *
     * @return  self
     */ 
    public function setStudent($student)
    {
        $this->student = $student;

        return $this;
    }

    public function jsonSerialize()
    {
        return 
        [
            'status'=> $this->getStatus(),
            'time'  => $this->getTime(),
        ];
    }
 
}