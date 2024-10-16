<?php
// Start session and include database connection
session_start();
include('../db/db_connect.php'); // Ensure this path is correct

// Check if stream_id is provided in GET request
if (isset($_GET['stream_id'])) {
    $stream_id = intval($_GET['stream_id']); // Sanitize input

    // Query to get subjects based on stream_id
    $query = "SELECT id, subject_name FROM subjects WHERE stream_id = ?";
    
    // Prepare and execute statement
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $stream_id); // Bind the stream ID
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch subjects as an array
        $subjects = array();
        while ($row = $result->fetch_assoc()) {
            $subjects[] = $row;
        }

        // Return the subjects as JSON
        echo json_encode($subjects);
    } else {
        // Error with query
        echo json_encode(array('error' => 'Query failed'));
    }
} else {
    // No stream ID provided
    echo json_encode(array('error' => 'No stream_id provided'));
}
?>
