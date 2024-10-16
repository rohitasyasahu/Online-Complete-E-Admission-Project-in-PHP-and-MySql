<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Database connection
include('../db/db_connect.php');

// Get the helpdesk information ID from the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the helpdesk information from the database
    $query = "DELETE FROM helpdesk WHERE id = '$id'";
    if ($conn->query($query) === TRUE) {
        echo "<p>Helpdesk information deleted successfully!</p>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
} else {
    echo "<p>No helpdesk information ID specified!</p>";
}

// Redirect back to the helpdesk management page
header('Location: helpdesk.php');
exit();
?>
