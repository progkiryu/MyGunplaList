<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        
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
            <button name="deleteButton">Delete Account</button>
            <button name="settingsBackButton">Back</button>
        </form>
        
    </body>
</html>

<?php

require_once "../controllers/list.con.php";
require_once "../controllers/user.con.php";

$listController = new ListController();
$userController = new UserController();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["deleteButton"])) {
        $listController->deleteTable();
        $userController->delete();
    }
    if (isset($_POST["settingsBackButton"])) {
        header("Location: list.php");
        exit;
    }
}