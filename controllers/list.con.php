<?php

require_once "../models/list.mod.php";

class ListController {
    private $listModel;

    public function __construct() {
        $this->listModel = new ListModel($_SESSION["username"]);
    }

    public function addGunpla() {
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
            $dateBuilt, NULL);
            if (!$result) {
                die("<h2>SQL Error!</h2>");
            }
        }
    }

    public function deleteGunpla() {
        $deleteRow = urldecode($_POST["deleteButton"]);
        $result = $this->listModel->remove($deleteRow);
        if (!$result) {
            die("<h2>SQL Error!</h2>");
        }
    }

    public function deleteTable() {
        $result = $this->listModel->removeTable();
        if (!$result) {
            die("<h2>SQL Error!</h2>");
        }
    }

    public function displayGunpla() {
        $result = $this->listModel->getAll();
        if ($result) {
            echo "<table>  
                    <tr>
                        <th>Grade</th>
                        <th>Scale</th>
                        <th>ModelName</th>
                        <th>DateBuilt</th>
                        <th>Image</th>
                    </tr>";
            foreach ($result as $row) {
                echo $row;
            }
            echo "</table>";
        }
        else {
            die("<h2>No gunpla! Add some!</h2>");
        }
    }   
}
