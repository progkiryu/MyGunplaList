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
        if (isset($_SESSION["username"])) echo "<h1>Welcome, " . $_SESSION["username"] . " to your Gunpla list!</h1>";
        else {
            session_unset();
            session_destroy();
            header("Location: login.php");
            die();
        }
        ?>

        <table>
            <tr>
                <th>Grade</th>
                <th>Scale</th>
                <th>Model Name</th>
                <th>Date Built</th>
                <th></th>
            </tr>

        <?php
        require_once "sqlConnection.php";
        $tableName = $_SESSION["username"] . "_gunpla";

        function refreshDisplay() {
        }
        $tableQuery = "SELECT Grade, Scale, ModelName, DateBuilt FROM '$tableName'";
        $tableResult = mysqli_query($connection, $tableQuery);

        if ($tableResult) {
            while ($row = $tableResult -> fetch_assoc()) {
                echo '<tr>
                        <td>' . $row["Grade"] . '</td>
                        <td>' . $row["Scale"] . '</td>
                        <td>' . $row["ModelName"] . '</td>
                        <td>' . $row["DateBuilt"] . '</td>
                        <td><button onclick="displayGunpla()">Delete</button>
                    </tr>';
            }
        }

        refreshDisplay();
        ?>

        </table>

        <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="get">
            <button name="settingsButton">Settings</button>
            <button name="loginButton">Logout</button>

        </form>

        <button id="displayButton" onclick="toggleDisplay(this)">Add Gunpla</button>

        <div id="addGunplaDisplay" hidden="hidden">
            <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
                <select name="gradeSelector" id="gradeSelector">
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
                <select name="scaleSelector" id="scaleSelector">
                    <option value="1/144">1/144</option>
                    <option value="1/100">1/100</option>
                    <option value="1/60">1/60</option>
                    <option value="1/35">1/35</option>
                    <option value="N/A">N/A</option>
                </select>
                <input type="text" name="modelName" id="scaleSelector" placeholder="Model Name:">
                <input type="date" name="dateBuilt" id="dateBuilt">
                <button onclick="addGunpla()">Enter</button>
            </form>
        </div>

        <?php
        if (isset($_GET["loginButton"])) {
            session_unset();
            session_destroy();
            header("Location: login.php");
            exit;
        }

        if (isset($_GET["settingsButton"])) {
            header("Location: settings.php");
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {  
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
                $newGunplaQuery = "INSERT INTO $tableName (Grade, Scale, ModelName, DateBuilt) VALUES ('$gradeSelector', '$scaleSelector', '$modelName', '$dateBuilt')";
                mysqli_query($connection, $newGunplaQuery);
                refreshDisplay();
            }
        }
        ?>
        <script src="js scripts/list.js"></script>
    </body>
</html>