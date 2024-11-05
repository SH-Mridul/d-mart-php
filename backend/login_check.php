<?php
// Start the session
session_start();

// Check if the user is logged in, and also check if username and email are set
if (!isset($_SESSION['is_login']) || $_SESSION['is_login'] !== true || !isset($_SESSION['username']) || !isset($_SESSION['email'])) {
    // If not logged in or if username or email is missing, redirect to login.php
    header("Location: login.php");
    exit;
}
?>