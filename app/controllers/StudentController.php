<?php

namespace app\controllers;

use database\repositories\LogRepository;
use database\repositories\StudentRepository;

class StudentController {

    private $studentRepository;
    private $logRepository;


    public function __construct() {
        $this->studentRepository = new StudentRepository();
        $this->logRepository = new LogRepository();

    }

    public function show($student_id, $lecture_id) {
        $logs = $this->logRepository->getByUserLecture( $student_id, $lecture_id );
        print_r(json_encode($logs));
        die();
    }

}