<?php


namespace app\models;

use database\repositories\LogRepository;
use database\repositories\LectureRepository;



class Lecture implements \JsonSerializable {
    private $id;

    private $date;
    private $file;

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

    public function endTime() {
        $lr = new LectureRepository();
        return $lr->getLectureEndTime( $this );
    }

    /**
     * Get the value of date
     */ 
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */ 
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get the value of file
     */ 
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set the value of file
     *
     * @return  self
     */ 
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    public function getStudentsNum() {
        $lr = new LectureRepository();
        return $lr->getNumberOfStudents( $this );
    }


    public function jsonSerialize()
    {
        return 
        [
            'numOfStudents' => $this->getStudentsNum($this)
        ];
    }
}