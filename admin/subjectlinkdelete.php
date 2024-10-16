<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

include('../db/db_connect.php'); // Database connection
include('header.php')
// Get the link ID from the URL
if (isset($_GET['id'])) {
    $link_id = $_GET['id'];

    // Delete the subject link from the database
    $delete_query = "DELETE FROM subject_links WHERE id = '$link_id'";

    if ($conn->query($delete_query) === TRUE) {
        echo "<p>Subject link deleted successfully!</p>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
} else {
    echo "<p>No subject link ID provided!</p>";
}

$conn->close(); // Close the database connection
?>

<a href="subjectlink.php">Back to Subject Links</a>
