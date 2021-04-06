<?php

namespace app\controllers;

use app\models\Loader;
use database\repositories\LectureRepository;
use database\repositories\StudentRepository;


class PagesController {

    private $lectureRepository;
    private $studentRepository;


    public function __construct() {
        $this->lectureRepository = new LectureRepository();
        $this->studentRepository = new StudentRepository();

    }


    public function index() {
        $loader = new Loader();
        $loader->pullData();
        $loader->loadDataToDB();

        $orderBy = '';
        $order = '';

        if( isset($_GET['orderBy']) ) {
            $orderBy = $_GET['orderBy'];
        }
        if( isset($_GET['order']) ) {
            $order = $_GET['order'];
        }


        $lectures = $this->lectureRepository->getAll();
        $students = $this->studentRepository->getAll( $orderBy, $order );

        return view('home', [
            'lectures'  => $lectures,
            'students'  => $students,
        ]);
    }


    public function stats() {
        $lectures = $this->lectureRepository->getAll();
        

        return view('stats', [
            'lectures'  => $lectures
        ]);
    }
}