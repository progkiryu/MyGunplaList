<?php

require_once "../models/list.mod.php";

class ListController {
    private $listModel;

    public function __construct() {
        $this->listModel = new ListModel($_SESSION["username"]);
    }

    public function addGunpla($mode) {
        $gradeSelector = htmlspecialchars($_POST["gradeSelector"]);
        $scaleSelector = htmlspecialchars($_POST["scaleSelector"]);
        $modelName = htmlspecialchars($_POST["modelName"]);
        $dateBuilt = $_POST["dateBuilt"];
        $image = NULL;

        $error = false;

        if (empty($gradeSelector) || empty($scaleSelector) || empty($modelName) || 
        empty($dateBuilt)) {
            echo "<h2>Fill in the fields!</h2>";
            $error = true;
        } 

        if (!$error) {
            if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] === UPLOAD_ERR_OK) {
                $imageResult = $this->listModel->addPhoto($_FILES["photo"]);
                if (!$imageResult) {
                    die("<h2>Error uploading file!</h2>");
                }
                $image = $_FILES["photo"]["name"];
            }

            $result = 0;
            if ($mode === 0) {
                $result = $this->listModel->add($gradeSelector, $scaleSelector, $modelName, 
                $dateBuilt, $image);
            }
            else if ($mode === 1) {
                $rowID = $_POST["editButton"];
                $result = $this->listModel->update($gradeSelector, $scaleSelector, $modelName,
                $dateBuilt, $image, $rowID);
            }
            if (!$result) {
                die("<h2>SQL Error!</h2>");
            }
        }
    }


    public function deleteGunpla() {
        $deleteRow = $_POST["deleteButton"];
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
                        <th>Model Name</th>
                        <th>Date Built</th>
                        <th>Image</th>
                        <th>Actions</th>
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
