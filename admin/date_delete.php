<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Database connection
include('../db/db_connect.php');

// Get the date ID from the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the date from the database
    $query = "DELETE FROM important_dates WHERE id = '$id'";
    if ($conn->query($query) === TRUE) {
        echo "<p>Important date deleted successfully!</p>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
} else {
    echo "<p>No important date ID specified!</p>";
}

// Redirect back to the date management page
header('Location: date.php');
exit();
?>