<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">

        <title>Login</title>
    </head>

    <body>
        <h1>Login.</h1>

        <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
            <input type="text" name="username" placeholder="Username:">
            <input type="password" name="password" placeholder="Password:">
            
            <button>Login</button>
        </form>

        <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="get">
            <button name="registerButton">Don't have an account? Sign up!</button>
        </form>

        <?php
        if (isset($_GET["registerButton"])) {
            header("Location: registration.php");
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            require_once "sqlConnection.php";

            $username = htmlspecialchars($_POST["username"]);
            $password = htmlspecialchars($_POST["password"]);

            $error = false;

            if (empty($username) || empty($password)) {
                echo "<h2>Fill in the fields!</h2>";
                $error = true;
            }
        
            if (!$error) {
                $sqlQuery = "SELECT * FROM Users WHERE Username = '$username'";
                $result = mysqli_query($connection, $sqlQuery);

                if ($result) {
                    $row = mysqli_fetch_assoc($result);
                    if ($row) {
                        if ($row["Password"] === $password) {
                            session_start();
                            $_SESSION["username"] = $username;
                            $_SESSION["password"] = $password;
                            header("Location: list.php");
                            exit;
                        } else die("<h2>Wrong password!</h2>");
                    } else die("<h2>No accounts made!</h2>");
                } else die("<h2>SQL ERROR!</h2>");
            }
        }
        ?>

    </body>
</html>