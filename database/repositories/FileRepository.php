<?php

namespace database\repositories;

use database\repositories\Repository;
use app\models\File;


class FileRepository extends Repository {

    public function get( $id ) {
        $sql = "SELECT * FROM file WHERE id = :id";
        $stmt = $this->conn->prepare( $sql );
        $stmt->setFetchMode( \PDO::FETCH_CLASS, File::class );
        $stmt->execute([
            'id'    => $id
        ]);

        $file = $stmt->fetch();

        if( $file ) {
            return $file;
        }

        return false;
    }

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
        if( $stmt ) {
            $insertedFile = $this->get( $this->conn->lastInsertId() );
            return $insertedFile;
        }

        return false;
    }

}