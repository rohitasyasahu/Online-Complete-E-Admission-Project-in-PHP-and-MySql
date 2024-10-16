<?php
include('../db/db_connect.php');

// Get subject ID from the query parameters
if (isset($_GET['subject_id'])) {
    $subject_id = $_GET['subject_id'];

    // Query to get the associated stream for the selected subject
    $query = "
        SELECT s.id, st.stream_name 
        FROM subject_links s
        JOIN streams st ON s.stream_id = st.id
        WHERE s.subject_id = '$subject_id'
    ";

    $result = $conn->query($query);
    $streams = [];

    while ($row = $result->fetch_assoc()) {
        $streams[] = $row;
    }

    // Return the streams as JSON
    echo json_encode(['streams' => $streams]);
} else {
    echo json_encode(['streams' => []]);
}

$conn->close(); // Close the database connection
?>
