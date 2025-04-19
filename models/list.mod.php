<?php

require_once "database.php";

class ListModel {
    private $database;

    public function __construct() {
        $this->database = Database::connect();
    }

    public function add($grade, $scale, $modelName, $dateBuilt, $file, $username) {
        $tableName = $username . "_gunpla";
        $newGunplaQuery = "INSERT INTO $tableName 
        (Grade, Scale, ModelName, DateBuilt, ImageFileName) VALUES 
        (?, ?, ?, ?, ?)";
        $statement = $this->database->prepare($newGunplaQuery);
        return $statement->execute([$grade, $scale, $modelName, $dateBuilt, $file]);
    }

    public function remove($rowID, $username) {
        $tableName = $username . "_gunpla";
        $deleteGunplaQuery = "DELETE FROM $tableName WHERE ModelName = ?";
        $statement = $this->database->prepare($deleteGunplaQuery);
        return $statement->execute([$rowID]);
    }

    public function changeGunpla() {
        echo "una yaha yaha una!";
    }
}