<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include '../db/db_connect.php';
include 'header.php'; // Include admin header

// Fetch students who have been accepted
$sql = "
    SELECT students.id, students.name, students.caste, streams.stream_name, subjects.subject_name 
    FROM students
    JOIN streams ON students.stream_id = streams.id
    JOIN subjects ON students.subject_id = subjects.id
    LEFT JOIN applications ON students.id = applications.student_id
    WHERE applications.status = 'Accepted'
";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merit List</title>
    <link rel="stylesheet" href="css/admin_dashboard.css"> <!-- Admin Dashboard CSS -->
</head>
<body>

<div class="main-content">
    <h2>Accepted Students - Merit List</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SlNo</th>
                <th>Name</th>
                <th>Stream</th>
                <th>Subject</th>
                <th>Caste</th>
                <th>View Form</th>
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
                    echo "<td><a href='view_student.php?id=" . $row['id'] . "' class='btn btn-primary'>View Form</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No students found in merit list.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php
$conn->close();
?>
