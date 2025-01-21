<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Settings</title>
    </head>

    <body>
        <?php
        session_start();
        if (!isset($_SESSION["username"])) {
            session_unset();
            session_destroy();
            header("Location: list.php");
            exit;
        }
        ?>
        
        <h1>Settings.</h1>

        <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
            <button>Delete Account</button>
        </form>

        <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="get">
            <button name="settings-back-button">Back</button>
        </form>

        <?php
        if (isset($_GET["settings-back-button"])) {
            header("Location: list.php");
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            require_once "sqlConnection.php";

            $TBDusername = $_SESSION["username"];

            $userQuery = "DELETE FROM Users WHERE Username = '$TBDusername'";
            mysqli_query($connection, $userQuery);

            $tableName = $TBDusername . "_gunpla";
            $tableQuery = "DROP TABLE IF EXISTS $tableName";
            mysqli_query($connection, $tableQuery);

            session_unset();
            session_destroy();
            header("Location: login.php");
            exit;
        }
        ?>
        
    </body>
</html>