<?php
session_start();

// Unset all of the session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to the homepage or login page
header("Location: ../index.php"); // Change to your desired redirect page
exit();
?>