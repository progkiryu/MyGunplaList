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

        <!-- Loads in gunpla data for each user -->
        <?php
        require_once "sqlConnection.php";
        $tableName = $_SESSION["username"] . "_gunpla";
        $tableQuery = "SELECT Grade, Scale, ModelName, DateBuilt FROM $tableName";
        $tableResult = mysqli_query($connection, $tableQuery);

        if ($tableResult) {
            if (mysqli_num_rows($tableResult) != 0) {
                echo '<table>
                        <tr>
                            <th>Grade</th>
                            <th>Scale</th>
                            <th>Model Name</th>
                            <th>Date Built</th>
                            <th>Image</th>
                            <th></th>
                        </tr>';
                while ($tableRow = $tableResult -> fetch_assoc()) {
                    echo '<tr>
                            <td>
                                <div>' . 
                                    $tableRow["Grade"] . 
                                '</div>
                                <input id="editGradeButton" hidden="hidden" type="text" value="' . urlencode($tableRow["Grade"]) . '">
                            </td>
                            <td>' . $tableRow["Scale"] . '</td>
                            <td>' . $tableRow["ModelName"] . '</td>
                            <td>' . $tableRow["DateBuilt"] . '</td>
                            <td> none for now! </td>
                            <td>
                                <form action="' . $_SERVER["PHP_SELF"] . '" method="post">
                                    <button name="deleteButton" value="' . urlencode($tableRow["ModelName"]) . '">Delete</button>
                                    <button name="editButton" value="' . urlencode($tableRow["ModelName"]) . '">Edit</button>
                                </form>
                            </td>
                        </tr>';
                }
                echo '</table>';
            } else echo '<h2>No gunpla, add some!</h2>';
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
                <input type="file" name="photos" value="" multiple>
                <button>Enter</button>
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
                $gunplaFolder = $username . "'s photos";

                $newGunplaQuery = "INSERT INTO $tableName (Grade, Scale, ModelName, DateBuilt) VALUES ( '$modelName', '$gradeSelector', '$scaleSelector', '$dateBuilt', '$gunplaFolder')";
                mysqli_query($connection, $newGunplaQuery);
                
                $newDirectory = __DIR__ . "/gundam photos/" . $gunplaFolder . "/" . $modelName;
                if (!is_dir($newDirectory)) {
                    mkdir($newDirectory, 0777, true);
                } else die("<h2>DIRECTORY ERROR!</h2>");

                header("Refresh: 0");
                exit;
            }
        }
        ?>
        <script src="js scripts/list.js"></script>
    </body>
</html>