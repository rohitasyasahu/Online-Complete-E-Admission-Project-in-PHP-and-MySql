<?php
// Start session and check if admin is logged in
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include '../db/db_connect.php';
include 'header.php';

// Get caste and stream from the query parameters
$caste = isset($_GET['caste']) ? $_GET['caste'] : '';
$stream_name = isset($_GET['stream']) ? $_GET['stream'] : '';

if (!$caste && !$stream_name) {
    echo "Invalid request. Caste or Stream not provided.";
    exit();
}

// Initialize student query variables
$sql = "";
$stmt = null;

// Check if filtering by caste
if ($caste) {
    $sql = "
        SELECT 
            id, name, father_name, mother_name, mobile, email, gender, caste
        FROM students
        WHERE caste = ?
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $caste);
} 
// Check if filtering by stream
elseif ($stream_name) {
    // First, fetch the stream ID based on stream name
    $stream_sql = "
        SELECT id FROM streams WHERE stream_name = ?
    ";
    $stream_stmt = $conn->prepare($stream_sql);
    $stream_stmt->bind_param('s', $stream_name);
    $stream_stmt->execute();
    $stream_result = $stream_stmt->get_result();

    // Check if stream exists
    if ($stream_result->num_rows > 0) {
        $stream_row = $stream_result->fetch_assoc();
        $stream_id = $stream_row['id'];

        // Now fetch students based on the stream ID
        $sql = "
            SELECT 
                id, name, father_name, mother_name, mobile, email, gender
            FROM students
            WHERE stream_id = ?
        ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $stream_id); // Bind stream_id as integer
    } else {
        echo "Invalid stream name.";
        exit();
    }
}

// Execute the student query
if ($stmt) {
    $stmt->execute();
    $result = $stmt->get_result();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Student Details</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Use your custom CSS here -->
</head>
<body>

<div class="main-content">
    <h2>
        <?php
        if ($caste) {
            echo "Student Details for Caste: " . htmlspecialchars($caste);
        } elseif ($stream_name) {
            echo "Student Details for Stream: " . htmlspecialchars($stream_name);
        }
        ?>
    </h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SlNo</th>
                <th>Name</th>
                <th>Father's Name</th>
                <th>Mother's Name</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Gender</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result && $result->num_rows > 0) {
                $slNo = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $slNo++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['father_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['mother_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['mobile']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No students found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php
if ($stmt) {
    $stmt->close();
}
$conn->close();
?>
