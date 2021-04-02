<?php

namespace database\repositories;

use database\repositories\Repository;
use app\models\File;


class FileRepository extends Repository {

    public function getAll() {
        $sql = "SELECT * FROM file";
        $stmt = $this->conn->query( $sql );
        $stmt->setFetchMode( \PDO::FETCH_CLASS, File::class );
        $files = $stmt->fetchAll();
        return $files;
    }


    public function add( File $file ) {
        $sql = "INSERT INTO file (name) VALUES (:name)";
        $stmt = $this->conn->prepare($sql);
        $stmt->setFetchMode( \PDO::FETCH_CLASS, File::class );
        $stmt->execute([
            'name'  => $file->getName(),
        ]);

        return true;
    }

}