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

    public function addPhoto($file) {
        $temp = $file["tmp_name"];
        $targetDirectory = "../gundam photos/" . $this->tableName . "/" . basename($file["name"]);
        if (move_uploaded_file($temp, $targetDirectory)) {
            return true;
        }
        return false;
    }
    
    public function remove($rowID) {
        $photoStatement = $this->database->prepare("SELECT ImageFileName FROM $this->tableName WHERE ModelName = ?");
        $photoStatement->execute([$rowID]);
        $fileResult = $photoStatement->fetchAll(PDO::FETCH_ASSOC);
        if (count($fileResult) == 1) {
            $photoResult = $this->removePhoto($fileResult[0]['ImageFileName']);
            if (!$photoResult) {
                return false;
            }
        }

        $deleteGunplaQuery = "DELETE FROM $this->tableName WHERE ModelName = ?";
        $statement = $this->database->prepare($deleteGunplaQuery);
        return $statement->execute([$rowID]);
    }

    public function removeTable() {
        $deleteTableQuery = "DROP TABLE $this->tableName";
        return $this->database->query($deleteTableQuery);
    }

    private function removePhoto($file) {
        $fileDirectory = "../gundam photos/" . $this->tableName . "/" . $file;
        if (file_exists($fileDirectory)) {
            if (unlink($fileDirectory)) {
                return true;
            }
        }
        return false;
    }

    public function getAll() {
        $displayQuery = "SELECT * FROM $this->tableName";
        $statement = $this->database->query($displayQuery);

        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        $array = [];

        if (count($rows) != 0) {
            foreach ($rows as $row) {
                $imagePath = $row['ImageFileName'];
                $directory = "../gundam photos/" . $this->tableName;
                $error = "this.outerHTML='<p>No image!</p>';";
                if (!is_null($imagePath)) {
                    $directory = $directory . "/" . $imagePath;
                }
                $line = '<tr>
                            <td>' . $row['Grade'] . '</td>
                            <td>' . $row['Scale'] . '</td>
                            <td>' . $row['ModelName'] . '</td>
                            <td>' . $row['DateBuilt'] . '</td>
                            <td>
                                <img src="' . $directory . '" onerror="' . $error . '">
                            </td>
                            <td>
                                <form action="' . htmlspecialchars("list.php") . '" method="post">
                                    <button name="deleteButton" value="' . urlencode($row['ModelName']) . '">Delete</button>
                                    <button name="changeButton" value="' . urlencode($row['ModelName']) . '">Edit</button>
                                </form>
                            </td>
                        </tr>';
                $array[] = $line;
            }
        }
        return $array;
    }
}