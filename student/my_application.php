<?php
session_start();
include '../db/db_connect.php'; // Your database connection file
include 'header.php';
// Check if user is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Get the student ID from session
$student_id = $_SESSION['student_id'];

// SQL query to retrieve application details along with student name, stream, and course (subject)
$sql = "
    SELECT a.id AS application_id, 
           st.name AS student_name, 
           s.stream_name, 
           sub.subject_name AS course_name,  -- Course Name from the subjects table
           a.status 
    FROM applications a 
    JOIN students st ON a.student_id = st.id 
    JOIN streams s ON st.stream_id = s.id 
    JOIN subjects sub ON st.subject_id = sub.id  -- Joining subjects table to get course/subject name
    WHERE a.student_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<html>
<head></head>
<body>
<br>
<?php
// Check if applications were found
if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>SlNo</th><th>Name</th><th>Stream</th><th>Course</th><th>Status</th></tr>"; // Added Course column

    $slNo = 1; // Initialize Serial Number
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $slNo++ . "</td>"; // Display SlNo
        echo "<td>" . htmlspecialchars($row['student_name']) . "</td>"; // Student Name
        echo "<td>" . htmlspecialchars($row['stream_name']) . "</td>"; // Stream Name
        echo "<td>" . htmlspecialchars($row['course_name']) . "</td>"; // Course (Subject Name)
        echo "<td>" . htmlspecialchars($row['status']) . "</td>"; // Status
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No applications found.";
}

$stmt->close();
$conn->close();

?>