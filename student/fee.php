<?php
session_start();
include '../db/db_connect.php'; // Your database connection file
include 'header.php';
// Check if user is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// SQL query to retrieve fee structure with stream and subject names
$sql = "
    SELECT fs.id AS fee_id, 
           s.stream_name, 
           sub.subject_name, 
           fs.fee_structure 
    FROM fee_structures fs 
    JOIN streams s ON fs.stream_id = s.id 
    JOIN subjects sub ON fs.subject_id = sub.id
    ORDER BY s.stream_name, sub.subject_name
";

$result = $conn->query($sql);

// Display the fee structure in a table format
if ($result->num_rows > 0) {
    echo "<h2>Fee Structure List</h2>";
    echo "<table border='1'>";
    echo "<tr><th>SlNo</th><th>Stream</th><th>Subject Name</th><th>Fee Structure</th></tr>";

    $slNo = 1; // Initialize Serial Number
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $slNo++ . "</td>"; // Display SlNo
        echo "<td>" . htmlspecialchars($row['stream_name']) . "</td>"; // Stream Name
        echo "<td>" . htmlspecialchars($row['subject_name']) . "</td>"; // Subject Name
        echo "<td>" . htmlspecialchars($row['fee_structure']) . "</td>"; // Fee Structure
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No fee structures found.";
}

$conn->close();
?>
