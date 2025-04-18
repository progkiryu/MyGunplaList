<?php

require_once "database.php";

class ListModel {
    private $database;

    public function __construct() {
        $this->database = Database::connect();
    }

    public function add($grade, $scale, $modelName, $dateBuilt, $file) {
        $tableName = $_SESSION["Username"] . "_gunpla";
        $newGunplaQuery = "INSERT INTO $tableName 
        (Grade, Scale, ModelName, DateBuilt, ImageFileName) VALUES 
        (?, ?, ?, ?, ?)";
        $statement = $this->database->prepare($newGunplaQuery);
        return $statement->execute([$grade, $scale, $modelName, $dateBuilt, $file]);
    }

    public function remove($rowID) {
        $tableName = $_SESSION["Username"] . "_gunpla";
        $deleteGunplaQuery = "DELETE FROM $tableName WHERE ModelName = ?";
        $statement = $this->database->prepare($deleteGunplaQuery);
        return $statement->execute([$rowID]);
    }

    public function changeGunpla() {

    }
}