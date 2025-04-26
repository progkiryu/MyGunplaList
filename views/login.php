<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">

        <title>Login</title>
        <link rel="stylesheet" href="style/login.css">
    </head>

    <body>
        <div>
            <h1>Login.</h1>

            <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
                <input class="item" type="text" name="username" placeholder="Username:">
                <input class="item" type="password" name="password" placeholder="Password:">
                    
                <button class="item">Login</button>
                <button class="item" name="regButton" type="submit">Don't have an account? Sign up!</button>
            </form>
        </div>

    </body>
</html>

<?php

require_once "../controllers/user.con.php";
$controller = new UserController();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["regButton"])) {
        header("Location: registration.php");
        exit;
    }
    $controller->login();
}
