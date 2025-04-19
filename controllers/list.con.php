<?php

require_once "../models/list.mod.php";

class ListController {
    private $listModel;

    public function __construct() {
        $this->listModel = new ListModel();
    }

    public function addGunpla() {
        session_start();
        $gradeSelector = htmlspecialchars($_POST["gradeSelector"]);
        $scaleSelector = htmlspecialchars($_POST["scaleSelector"]);
        $modelName = htmlspecialchars($_POST["modelName"]);
        $dateBuilt = $_POST["dateBuilt"];

        $error = false;

        if (empty($gradeSelector) || empty($scaleSelector) || empty($modelName) || 
        empty($dateBuilt)) {
            echo "<h2>Fill in the fields!</h2>";
            $error = true;
        } 

        if (!$error) {
            $result = $this->listModel->add($gradeSelector, $scaleSelector, $modelName, 
            $dateBuilt, NULL, $_SESSION["username"]);
            if ($result) {
                exit;
            }
            else {
                die("<h2>SQL Error!</h2>");
            }
        }
    }

    public function removeGunpla() {
        session_start();
        $deleteRow = urldecode($_POST["deleteButton"]);
        $result = $this->listModel->remove($deleteRow, $_SESSION["username"]);
        if ($result) {
            exit;
        }
        else {
            die("<h2>SQL Error!</h2>");
        }
    }
}
