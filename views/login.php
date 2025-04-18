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

        <form action=<?php echo htmlspecialchars("registration.php"); ?> method="get">
            <button>Don't have an account? Sign up!</button>
        </form>

    </body>
</html>

<?php

require_once "../controllers/user.con.php";
$controller = new UserController();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $controller->login();
}
