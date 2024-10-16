<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Database connection
include('../db/db_connect.php');

// Get the seat ID from the URL
if (isset($_GET['id'])) {
    $seat_id = $_GET['id'];

    // Delete the seat allocation from the database
    $delete_query = "DELETE FROM seats WHERE id = '$seat_id'";

    if ($conn->query($delete_query) === TRUE) {
        echo "<p>Seat allocation deleted successfully!</p>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
} else {
    echo "<p>No seat allocation ID specified!</p>";
}

// Redirect back to the seat management page
header('Location: seat_list.php');
exit();
?>
