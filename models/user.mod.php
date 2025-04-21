<?php

require_once "database.php";

class User {
    private $database;

    public function __construct() {
        $this->database = Database::connect();
    }

    public function checkUser($username, $password) {
        $statement = $this->database->prepare("SELECT * FROM Users WHERE Username = ?");
        $statement->execute([$username]);
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        if ($user && $user['Password'] === $password) {
            return true;
        }
        return false;
    }

    public function insert($username, $password) {
        $statement = $this->database->prepare("INSERT INTO Users (Username, Password) VALUES 
        (?, ?)");
        return $statement->execute([$username, $password]);
    }

    public function createTable($username) {
        $newTableName = $username . "_gunpla";
        $query = "CREATE TABLE $newTableName (
            GunplaID INT NOT NULL AUTO_INCREMENT,
            ModelName VARCHAR(255) NOT NULL,
            Grade VARCHAR(4),
            Scale VARCHAR(5),
            DateBuilt DATE,
            ImageFileName VARCHAR(255),
            CONSTRAINT PK_$newTableName PRIMARY KEY (GunplaID, ModelName)
        )";
        $statement = $this->database->prepare($query);
        return $statement->execute();
    }

    public function createFolder($username) {
        $folderName = $username . "_gunpla";
        $newDirectory = "../gundam photos/" . $folderName;
        if (!is_dir($newDirectory)) {
            mkdir($newDirectory, 0777, true);
            return true;
        }
        return false;
    }

    public function checkUsername($username) {
        $statement = $this->database->prepare("SELECT * FROM Users WHERE Username = ?");
        $statement->execute([$username]);
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            return true;
        }
        return false;
    }

    public function remove($username) {
        $statement = $this->database->prepare("DELETE FROM Users WHERE Username = ?");
        return $statement->execute([$username]);
    }
}