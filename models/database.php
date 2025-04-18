<?php

class Database {
    public static function connect() {
        $serverName = "localhost";
        $username = "root";
        $password = "Fallout4!";
        $database = "testing";

        try {
            return new PDO("mysql:host=$serverName;dbname=$database", $username, $password);
        } 
        catch (PDOException $err) {
            die("SQL ERROR: " . $err->getMessage());
        }
    }
}