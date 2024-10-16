<?php
session_start(); // Start the session

// Destroy all session variables
session_destroy();

// Redirect to login.php
header("Location: login.php");
exit;
?>