<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}
include 'header.php';
// Database connection
include('../db/db_connect.php');

// Get the fee ID from the URL
if (isset($_GET['id'])) {
    $fee_id = $_GET['id'];

    // Delete the fee structure from the database
    $delete_query = "DELETE FROM fee_structures WHERE id = '$fee_id'";

    if ($conn->query($delete_query) === TRUE) {
        echo "<p>Fee structure deleted successfully!</p>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
} else {
    echo "<p>No fee structure ID specified!</p>";
}

// Redirect back to the fee structure management page
header('Location: fee_structure.php');
exit();
?>
