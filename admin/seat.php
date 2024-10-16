<?php
// Start session and check if admin is logged in
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include '../db/db_connect.php'; // Include the database connection
include 'header.php'; // Include the admin header

// SQL query to get seat information subject-wise and caste-wise
$sql = "
    SELECT 
        subjects.subject_name,
        streams.stream_name,
        seats.total_seats,
        seats.general_seats,
        seats.obc_seats,
        seats.sc_seats,
        seats.st_seats,
        COUNT(CASE WHEN students.caste = 'General' THEN 1 END) as filled_general,
        COUNT(CASE WHEN students.caste = 'OBC' THEN 1 END) as filled_obc,
        COUNT(CASE WHEN students.caste = 'SC' THEN 1 END) as filled_sc,
        COUNT(CASE WHEN students.caste = 'ST' THEN 1 END) as filled_st
    FROM seats
    JOIN streams ON seats.stream_id = streams.id
    JOIN subjects ON seats.subject_id = subjects.id
    LEFT JOIN students ON students.stream_id = seats.stream_id AND students.subject_id = seats.subject_id
    GROUP BY seats.stream_id, seats.subject_id
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Seat Report</title>
    <link rel="stylesheet" href="css/admin_dashboard.css"> <!-- Add your admin dashboard CSS -->
</head>
<body>

<div class="main-content">
    <h2>Seat Report (Caste Wise and Subject Wise)</h2>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Stream</th>
                <th>Subject</th>
                <th>Total Seats</th>
                <th>Filled Seats (General)</th>
                <th>Vacant Seats (General)</th>
                <th>Filled Seats (OBC)</th>
                <th>Vacant Seats (OBC)</th>
                <th>Filled Seats (SC)</th>
                <th>Vacant Seats (SC)</th>
                <th>Filled Seats (ST)</th>
                <th>Vacant Seats (ST)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Calculate vacant seats for each category
                    $vacant_general = $row['general_seats'] - $row['filled_general'];
                    $vacant_obc = $row['obc_seats'] - $row['filled_obc'];
                    $vacant_sc = $row['sc_seats'] - $row['filled_sc'];
                    $vacant_st = $row['st_seats'] - $row['filled_st'];

                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['stream_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['subject_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['total_seats']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['filled_general']) . "</td>";
                    echo "<td>" . htmlspecialchars($vacant_general) . "</td>";
                    echo "<td>" . htmlspecialchars($row['filled_obc']) . "</td>";
                    echo "<td>" . htmlspecialchars($vacant_obc) . "</td>";
                    echo "<td>" . htmlspecialchars($row['filled_sc']) . "</td>";
                    echo "<td>" . htmlspecialchars($vacant_sc) . "</td>";
                    echo "<td>" . htmlspecialchars($row['filled_st']) . "</td>";
                    echo "<td>" . htmlspecialchars($vacant_st) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='11'>No seat data available.</td></tr>";
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
