<?php

require_once "../models/user.mod.php";

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function loginUser() {
        $username = htmlspecialchars($_POST["username"]);
        $password = htmlspecialchars($_POST["password"]);

        $error = false;

        if (empty($username) || empty($password)) {
            echo "<h2>Fill in the fields!</h2>";
            $error = true;
        }
        
        if (!$error) {
            $result = $this->userModel->login($username, $password);
            echo $result;
            if ($result) {
                session_start();
                $_SESSION["username"] = $username;
                header("Location: list.php");
                exit;
            }
            else {
                die("<h2>SQL Error!</h2>");
            }
        }
    }

    public function registerUser() {
        $username = htmlspecialchars($_POST["newUsername"]);
        $password = htmlspecialchars($_POST["newPassword"]);
        $repeatPassword = htmlspecialchars($_POST["repeatPassword"]);

        $error = false;

        if (empty($username) || empty($password) || empty($repeatPassword)) {
            echo "<h2>Fill in the fields!</h2>";
            $error = true;
        }

        if ($repeatPassword != $password) {
            echo "<h2>Confirm the password!</h2>";
            $error = true;
        }

        $userResult = $this->userModel->checkUser($username);
        if ($userResult) {
            echo "<h2>Username already taken!</h2>";
            $error = true;
        }
            
        if (!$error) {
            $result = $this->userModel->register($username, $password);
            $tableResult = $this->userModel->createTable($username);
            if ($result && $tableResult) {
                session_start();
                $_SESSION["username"] = $username;
                header("Location: list.php");
                exit;
            }
            else {
                die("<h2>SQL Error!</h2>");
            }
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit;
    }
}