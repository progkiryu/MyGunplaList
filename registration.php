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
                echo "<h2>Username already taken!</h2>";
                $error = true;
            }
            
            if (!$error) {
                $newUserQuery = "INSERT INTO Users (Username, Password) VALUES ('$newUsername', '$newPassword')";
                mysqli_query($connection, $newUserQuery);

                $newTableName = $newUsername . "_gunpla";
                $newGundamQuery = "CREATE TABLE $newTableName (
                    GunplaID INT NOT NULL AUTO_INCREMENT,
                    Grade VARCHAR(4),
                    Scale VARCHAR(5),
                    ModelName VARCHAR(255),
                    DateBuilt DATE,
                    CONSTRAINT PK_$newTableName PRIMARY KEY (GunplaID)
                )";
                mysqli_query($connection, $newGundamQuery);

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