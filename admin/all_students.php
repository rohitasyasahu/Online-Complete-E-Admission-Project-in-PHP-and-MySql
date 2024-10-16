<?php
// Start session and check if admin is logged in
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include '../db/db_connect.php'; // Include the database connection
include 'header.php'; // Include the admin header

// SQL query to fetch student details, along with stream and subject names
$sql = "
    SELECT 
        students.id,
        students.name,
        streams.stream_name,
        subjects.subject_name,
        students.caste
    FROM students
    JOIN streams ON students.stream_id = streams.id
    JOIN subjects ON students.subject_id = subjects.id
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - All Students</title>
    <link rel="stylesheet" href="css/admin_dashboard.css"> <!-- Admin dashboard CSS -->
</head>
<body>

<div class="main-content">
    <h2>All Students</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SlNo</th>
                <th>Name</th>
                <th>Stream</th>
                <th>Subject</th>
                <th>Caste</th>
                <th>View Form</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                $slNo = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $slNo++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['stream_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['subject_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['caste']) . "</td>";
                    // View form link
                    echo "<td><a href='view_student.php?id=" . urlencode($row['id']) . "' class='btn btn-primary'>View Form</a></td>";
                    // Action buttons (Edit and Delete)
                    echo "<td>";
                    echo "<a href='edit_student.php?id=" . urlencode($row['id']) . "' class='btn btn-warning'>Edit</a> ";
                    echo "<a href='delete_student.php?id=" . urlencode($row['id']) . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this student?\")'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No students found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php
$conn->close(); // Close the database connection
?>

</body>
</html>
