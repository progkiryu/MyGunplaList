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
            
            <button type="submit">Register</button>
            <button name="loginBackButton">Back</button>
        </form>
    </body>
</html>

<?php

require_once "../controllers/user.con.php";
$controller = new UserController();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["loginBackButton"])) {
        header("Location: login.php");
        exit;
    }
    $controller->register();
}