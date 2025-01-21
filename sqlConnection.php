<?php

$serverName = "localhost";
$username = "root";
$password = "Fallout4!";
$database = "testing";

$connection = mysqli_connect($serverName, $username, $password, $database);

if (!$connection) {
    die("Connection error: " . mysqli_connect_error());
}