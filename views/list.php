<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        
        <title>MyGunplaList</title>
        <link rel="stylesheet" href="style/list.css">
        <script src="../scripts/list.js"></script>
    </head>

    <body>
        <div id="main-container">
            
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
                <button name="logoutButton">Logout</button>
            </form>

            <button id="displayButton" onclick="toggleDisplay(this)">Add Gunpla</button>

            <div id="addGunplaDisplay" hidden="hidden">
                <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post" 
                    enctype="multipart/form-data">
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
                    <input type="file" name="photo" accept=".jpg, .jpeg, .png">
                    <button name="addButton" type="submit">Enter</button>
                </form>

            </div>

            <?php

            require_once "../controllers/user.con.php";
            require_once "../controllers/list.con.php";

            $listController = new ListController();
            $userController = new UserController();
            
            if (isset($_GET["logoutButton"])) {
                $userController->logout();
            }
            
            if (isset($_GET["settingsButton"])) {
                header("Location: settings.php");
                exit;
            }  
            
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST["deleteButton"])) {
                    $listController->deleteGunpla();
                }
                if (isset($_POST["addButton"])) {
                    $listController->addGunpla(0);
                }
                if (isset($_POST["editButton"])) {
                    $listController->addGunpla(1);
                }

                header("Location: " . $_SERVER["PHP_SELF"]);
                exit;
            }

            $listController->displayGunpla();
            
            ?>
            
        </div>

    </body>
</html>