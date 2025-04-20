<?php

require_once "database.php";

class ListModel {
    private $database;
    private $tableName;

    public function __construct($name) {
        $this->database = Database::connect();
        $this->tableName = $name . "_gunpla";
    }

    public function add($grade, $scale, $modelName, $dateBuilt, $file) {
        $newGunplaQuery = "INSERT INTO $this->tableName 
        (Grade, Scale, ModelName, DateBuilt, ImageFileName) VALUES 
        (?, ?, ?, ?, ?)";
        $statement = $this->database->prepare($newGunplaQuery);
        return $statement->execute([$grade, $scale, $modelName, $dateBuilt, $file]);
    }

    public function remove($rowID) {
        $deleteGunplaQuery = "DELETE FROM $this->tableName WHERE ModelName = ?";
        $statement = $this->database->prepare($deleteGunplaQuery);
        return $statement->execute([$rowID]);
    }

    public function removeTable() {
        $deleteTableQuery = "DROP TABLE $this->tableName";
        $statement = $this->database->prepare($deleteTableQuery);
        return $statement->execute();
    }

    public function getAll() {
        $displayQuery = "SELECT * FROM $this->tableName";
        $statement = $this->database->query($displayQuery);

        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        $array = [];

        if (count($rows) != 0) {
            foreach ($rows as $row) {
                $image = $row['ImageFileName'];
                if (is_null($image)) {
                    $image = "No image!";
                }
                $line = "<tr>
                            <td>" . $row['Grade'] . "</td>
                            <td>" . $row['Scale'] . "</td>
                            <td>" . $row['ModelName'] . "</td>
                            <td>" . $row['DateBuilt'] . "</td>
                            <td>" . $image . "</td>
                        </tr>";
                $array[] = $line;
            }
        }
        return $array;
    }
}