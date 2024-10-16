<?php
// Start session and check if admin is logged in
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php"); // Redirect to login if admin is not logged in
    exit();
}

include '../db/db_connect.php'; // Include the database connection
include 'header.php'; // Include the admin header

// SQL query to get the number of students by caste
$sql_caste = "
    SELECT 
        caste,
        COUNT(*) as total_students 
    FROM students
    GROUP BY caste
";
$result_caste = $conn->query($sql_caste);

// SQL query to get the number of students by stream
$sql_stream = "
    SELECT 
        s.stream_name,
        COUNT(*) as total_students 
    FROM students st
    JOIN streams s ON st.stream_id = s.id
    GROUP BY s.stream_name
";
$result_stream = $conn->query($sql_stream);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Total Student Dashboard</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Link to your custom admin dashboard CSS -->
</head>
<body>

<div class="main-content">
            <h2>Student Caste-wise Information</h2>
            <table class="table">
                    <tr>
                        <th>SlNo</th>
                        <th>Caste</th>
                        <th>Total Students</th>
                        <th>View Details</th>
                    </tr>
                    <?php
                    if ($result_caste->num_rows > 0) {
                        $slNo = 1;
                        while ($row = $result_caste->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $slNo++ . "</td>";
                            echo "<td>" . htmlspecialchars($row['caste']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['total_students']) . "</td>";
                            echo "<td><a href='student_details.php?caste=" . urlencode($row['caste']) . "'>View Students</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No students found.</td></tr>";
                    }
                    ?>
            </table>
        </div>

        <!-- Stream-wise Information -->
        <div class="main-content">
            <h2>Student Stream-wise Information</h2>
            <table>
                <thead>
                    <tr>
                        <th>SlNo</th>
                        <th>Stream</th>
                        <th>Total Students</th>
                        <th>View Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_stream->num_rows > 0) {
                        $slNo = 1;
                        while ($row = $result_stream->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $slNo++ . "</td>";
                            echo "<td>" . htmlspecialchars($row['stream_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['total_students']) . "</td>";
                            echo "<td><a href='student_details.php?stream=" . urlencode($row['stream_name']) . "'>View Students</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No students found.</td></tr>";
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
