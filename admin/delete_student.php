<?php
// Start session and check if admin is logged in
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include '../db/db_connect.php'; // Include your database connection file

// Get the student ID from the query parameter
$student_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($student_id <= 0) {
    echo "Invalid student ID.";
    exit();
}

// Prepare the SQL DELETE query
$sql = "DELETE FROM students WHERE id = ?";

// Prepare statement
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $student_id);

if ($stmt->execute()) {
    // If deletion is successful, redirect to a success or overview page
    header("Location: all_students.php?message=Student deleted successfully");
} else {
    // If there's an error, display the error
    echo "Error deleting student: " . $conn->error;
}

$stmt->close();
$conn->close(); // Close the database connection
?>
