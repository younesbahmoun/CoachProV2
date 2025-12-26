<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["pwd"];
    require_once '../classes/Dbh.php';
    require_once '../classes/Signup.php';
    $signup = new Signup($username, $password);
    $signup->signupUser();
}
?>