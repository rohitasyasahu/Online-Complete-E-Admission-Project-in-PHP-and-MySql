<?php
session_start();
include '../db/db_connect.php'; // Your database connection file
include 'header.php';
// Check if user is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// SQL query to retrieve seat details along with stream and subject names
$sql = "
    SELECT se.id AS seat_id, 
           s.stream_name, 
           sub.subject_name, 
           se.total_seats, 
           se.general_seats, 
           se.obc_seats, 
           se.sc_seats, 
           se.st_seats 
    FROM seats se
    JOIN streams s ON se.stream_id = s.id 
    JOIN subjects sub ON se.subject_id = sub.id
    ORDER BY s.stream_name, sub.subject_name
";

$result = $conn->query($sql);

// Display the seat structure in a table format
if ($result->num_rows > 0) {
    echo "<h2>Seat Allocation List</h2>";
    echo "<table border='1'>";
    echo "<tr>
            <th>SlNo</th>
            <th>Stream</th>
            <th>Subject</th>
            <th>Total Seats</th>
            <th>General Seats</th>
            <th>OBC Seats</th>
            <th>SC Seats</th>
            <th>ST Seats</th>
          </tr>";

    $slNo = 1; // Initialize Serial Number
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $slNo++ . "</td>"; // Display SlNo
        echo "<td>" . htmlspecialchars($row['stream_name']) . "</td>"; // Stream Name
        echo "<td>" . htmlspecialchars($row['subject_name']) . "</td>"; // Subject Name
        echo "<td>" . htmlspecialchars($row['total_seats']) . "</td>"; // Total Seats
        echo "<td>" . htmlspecialchars($row['general_seats']) . "</td>"; // General Seats
        echo "<td>" . htmlspecialchars($row['obc_seats']) . "</td>"; // OBC Seats
        echo "<td>" . htmlspecialchars($row['sc_seats']) . "</td>"; // SC Seats
        echo "<td>" . htmlspecialchars($row['st_seats']) . "</td>"; // ST Seats
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No seat allocation found.";
}

$conn->close();
?>
