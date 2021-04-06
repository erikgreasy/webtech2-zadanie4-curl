<?php

namespace app\models;

use app\models\Log;
use app\models\Lecture;
use app\models\Student;
use database\repositories\LogRepository;
use database\repositories\FileRepository;
use database\repositories\LectureRepository;
use database\repositories\StudentRepository;

class Loader {


    private $rawData = [];
    private $pulledFiles;
    private $fileRepository;
    private $studentRepository;
    private $lectureRepository;
    private $logRepository;




    public function __construct() {
        $this->fileRepository = new FileRepository();
        $this->studentRepository = new StudentRepository();
        $this->lectureRepository = new LectureRepository();
        $this->logRepository = new LogRepository();
    }

    public function pullData() {
        
        // create curl resource
        $ch = curl_init();

        // // set url
        curl_setopt($ch, CURLOPT_URL, 'https://github.com/apps4webte/curldata2021');

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($ch);

        curl_close($ch);


        $dom = new \DOMDocument();
        $dom->loadHTML($output, LIBXML_NOWARNING | LIBXML_NOERROR);

        $documentElement = $dom->getElementById('files');
        $finder = new \DomXPath($dom);
        $classname="js-navigation-open Link--primary";
        $nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
        $files = [];


        foreach( $nodes as $index => $node ) {
            $files[] = $node->nodeValue;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://raw.githubusercontent.com/apps4webte/curldata2021/main/' . $node->nodeValue);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $output = curl_exec($ch);
            $output = mb_convert_encoding($output, "UTF-8", "UTF-16");

            $this->rawData[$node->nodeValue] = $output;
        }

        $this->files = $files;
    }

    public function getNewFiles() {
        $dbFiles = $this->fileRepository->getAll();
        $dbFilesNames = array_map( function($file) {
            return $file->getName();
        }, $dbFiles );

        $newFiles = [];

        foreach( $this->files as $file ) {
            if( !in_array( $file, $dbFilesNames ) ) {
                $newFiles[] = $file;
            }
        }

        return $newFiles;
    }

    public function processDateString( $fileName ) {
        $dateStr = explode( "_", $fileName )[0];
        return date( 'Y-m-d', strtotime($dateStr) );
    }

    public function loadDataToDB() {

        $newFiles = $this->getNewFiles();

        foreach( $newFiles as $file ) {
            $data = $this->rawData[ $file ];
            $logs = explode("\n", $data);


            // delete first and last item cause they're shit
            unset($logs[0]);
            array_pop( $logs );

            
            $newFile = new File();
            $newFile->setName($file);
            $newFile = $this->fileRepository->add($newFile);

            
            $lecture = new Lecture();
            $lecture->setDate( $this->processDateString($file) );
            $lecture->setFile($newFile);
            $lecture = $this->lectureRepository->add( $lecture );

            foreach( $logs as $log ) {
                $log = explode("\t", $log);
                $name = $log[0];
                $status = $log[1];
                $time = $log[2];


                $student = $this->studentRepository->getByName( $name );
                if( ! $student ) {
                    $student = new Student();
                    $student->setName( $name );
                    $student = $this->studentRepository->add( $student );
                    $newStudents[] = $student;
                }

                
                $newLog = new Log();
                $newLog->setStatus( $status );
                $newLog->setTime( $time );
                $newLog->setLecture( $lecture );
                $newLog->setStudent( $student );

                $newLog = $this->logRepository->add( $newLog );

            }


            
        }
        
    }

}