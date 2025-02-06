<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">

        <title>Registration</title>
    </head>

    <body>
        <h1>Registration.</h1>

        <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
            <input type="text" name="newUsername" placeholder="New Username:">

            <input type="password" name="newPassword" placeholder="New Password:">
            <input type="password" name="repeatPassword" placeholder="Confirm Password:">
            
            <button>Register</button>
        </form>

        <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="get">
            <button name="loginButton">Back</button>
        </form>

        <?php
        if (isset($_GET["loginButton"])) {
            header("Location: login.php");
            exit;
        }
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            require_once "sqlConnection.php";

            $newUsername = htmlspecialchars($_POST["newUsername"]);
            $newPassword = htmlspecialchars($_POST["newPassword"]);
            $repeatPassword = htmlspecialchars($_POST["repeatPassword"]);

            $error = false;

            if (empty($newUsername) || empty($newPassword) || empty($repeatPassword)) {
                echo "<h2>Fill in the fields!</h2>";
                $error = true;
            }

            if ($repeatPassword != $newPassword) {
                echo "<h2>Confirm the password!</h2>";
                $error = true;
            }

            $checkQuery = "SELECT * FROM Users WHERE Username = '$newUsername'";
            $checkResult = mysqli_query($connection, $checkQuery);
            if ($checkResult) {
                $checkRow = mysqli_fetch_row($checkResult);
                if ($checkRow) {
                    echo "<h2>Username already taken!</h2>";
                    $error = true;
                }
            } else die("<h2>SQL ERROR!</h2>");
            
            if (!$error) {
                $newUserQuery = "INSERT INTO Users (Username, Password) VALUES ('$newUsername', '$newPassword')";
                mysqli_query($connection, $newUserQuery);

                $newTableName = $newUsername . "_gunpla";
                $newGundamQuery = "CREATE TABLE $newTableName (
                    GunplaID INT NOT NULL AUTO_INCREMENT,
                    ModelName VARCHAR(255) NOT NULL,
                    Grade VARCHAR(4),
                    Scale VARCHAR(5),
                    DateBuilt DATE,
                    ImageFolder VARCHAR(255),
                    CONSTRAINT PK_$newTableName PRIMARY KEY (GunplaID, ModelName)
                )";
                mysqli_query($connection, $newGundamQuery);

                $newFolder = $newUsername . "'s photos";
                $currentDirectory = __DIR__ . "/gundam photos/" . $newFolder;
                if (!is_dir($currentDirectory)) {
                    mkdir($currentDirectory, 0777, true);
                } else die("<h2>DIRECTORY ERROR!</h2>");

                session_start();
                $_SESSION["username"] = $newUsername;
                $_SESSION["password"] = $newPassword;
                header("Location: list.php");
                exit;
            }
        }
        ?>
    </body>
</html>