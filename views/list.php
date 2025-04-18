<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>MyGunplaList</title>
        <link rel="stylesheet" href="list.css">
    </head>

    <body>
        <?php
        session_start();
        if (isset($_SESSION["username"])) echo "<h1>Welcome " . $_SESSION["username"] . ", to your Gunpla list!</h1>";
        else {
            session_unset();
            session_destroy();
            header("Location: login.php");
            die();
        }
        ?>

        <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="get">
            <button name="settingsButton">Settings</button>
            <button name="loginButton">Logout</button>

        </form>

        <button id="displayButton" onclick="toggleDisplay(this)">Add Gunpla</button>

        <div id="addGunplaDisplay" hidden="hidden">
            <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
                <select name="gradeSelector">
                    <option value="SD">SD</option>
                    <option value="HG">HG</option>
                    <option value="RG">RG</option>
                    <option value="MG">MG</option>
                    <option value="MGEX">MGEX</option>
                    <option value="PG">PG</option>
                    <option value="MS">MS</option>
                    <option value="HIRM">HIRM</option>
                    <option value="FM">FM</option>
                </select>
                <select name="scaleSelector">
                    <option value="1/144">1/144</option>
                    <option value="1/100">1/100</option>
                    <option value="1/60">1/60</option>
                    <option value="1/35">1/35</option>
                    <option value="N/A">N/A</option>
                </select>
                <input type="text" name="modelName" placeholder="Model Name:">
                <input type="date" name="dateBuilt">
                <input type="file" name="photo" accept=".png, .jpeg, .jpg">
                <button>Enter</button>
            </form>
        </div>

        <?php

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (isset($_POST["deleteButton"])) {
                $deleteRow = urldecode($_POST["deleteButton"]);
                $deleteGunplaQuery = "DELETE FROM $tableName WHERE ModelName = '$deleteRow'";
                mysqli_query($connection, $deleteGunplaQuery);
                header("Refresh: 0");
                exit;
            }
            if (isset($_POST["editButton"])) {
                $editRow = urldecode($_POST["editButton"]);
                header("Refresh: 0");
                exit;
            }

            $gradeSelector = htmlspecialchars($_POST["gradeSelector"]);
            $scaleSelector = htmlspecialchars($_POST["scaleSelector"]);
            $modelName = htmlspecialchars($_POST["modelName"]);
            $dateBuilt = $_POST["dateBuilt"];

            $error = false;

            if (empty($gradeSelector) || empty($scaleSelector) || empty($modelName) || empty($dateBuilt)) {
                echo "<h2>Fill in the fields!</h2>";
                $error = true;
            } 

            if (!$error) {
                $newGunplaQuery = "INSERT INTO $tableName (Grade, Scale, ModelName, DateBuilt, ImageFileName) VALUES ('$gradeSelector', '$scaleSelector', '$modelName', '$dateBuilt', NULL)";
                mysqli_query($connection, $newGunplaQuery);
                

                header("Refresh: 0");
                exit;
            }
        }
        ?>
        <script src="scripts/list.js"></script>
    </body>
</html>

<?php

require_once "../controllers/list.con.php";
require_once "../controllers/user.con.php";

$listController = new ListController();
$userController = new UserController();

if (isset($_GET["loginButton"])) {
    $userController->logout();
}

if (isset($_GET["settingsButton"])) {
    header("Location: settings.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["deleteButton"])) {
        $listController->removeGunpla();
        exit;
    }
} 