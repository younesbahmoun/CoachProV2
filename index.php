<?php
session_start();

/**
 * Fake login for testing only.
 * It simulates a logged-in user without checking DB.
 */

$_SESSION["user"] = [
    "id" => 1,
    "nom" => "Test",
    "prenom" => "User",
    "email" => "test@example.com",
    "role" => "coach" // or "coach"
];

header("Location: ../pages/dashboard.php");
exit;