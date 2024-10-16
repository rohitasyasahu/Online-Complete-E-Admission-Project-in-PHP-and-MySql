<?php
session_start();
include '../db/db_connect.php'; // Your database connection file
include 'header.php';
// Check if user is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Query to retrieve important dates
$sql = "SELECT event_name, event_date FROM important_dates ORDER BY event_date DESC";
$result = $conn->query($sql);

// Display the dates in a table format
if ($result->num_rows > 0) {
    echo "<h2>Important Updates</h2>";
    echo "<table border=''>";
    echo "<tr><th>Event Name</th><th>Event Date</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['event_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['event_date']) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No important dates found.";
}

$conn->close();
?>