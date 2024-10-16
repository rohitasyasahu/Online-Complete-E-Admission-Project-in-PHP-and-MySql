<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Database connection
include('../db/db_connect.php');

// Delete subject
if (isset($_GET['id'])) {
    $subject_id = $_GET['id'];
    $query = "DELETE FROM subjects WHERE id='$subject_id'";

    if ($conn->query($query) === TRUE) {
        echo "<p>Subject deleted successfully!</p>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}

header("Location: subject_list.php"); // Redirect to subject list after deletion
exit();
?>
