<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "myvault";
$con = new mysqli($host, $user, $pass, $dbname);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>