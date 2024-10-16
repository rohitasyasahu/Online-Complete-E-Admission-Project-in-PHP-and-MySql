<?php
session_start();

// Check if the student is logged in
if (!isset($_SESSION['student_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Database connection
include('../db/db_connect.php');
// Fetch logged-in student's details using session data
$student_id = $_SESSION['student_id'];
$query = "SELECT * FROM students WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #4CAF50;
            padding: 15px;
            text-align: center;
            color: white;
        }
        .container {
            margin: 20px;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .form-heading {
            font-size: 1.5em;
            margin-bottom: 20px;
        }
        fieldset {
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        legend {
            font-weight: bold;
        }
    </style>
</head>
<body>
<?php include 'header.php' ?>;
<div class="header">
    <h1>Welcome to Your Student Dashboard</h1>
</div>

<div class="container">
    <h2 class="form-heading">Student Information</h2>
    
    <!-- Personal Information -->
    <fieldset>
        <legend>Personal Information</legend>
        <table>
            <tr><th>Name</th><td><?php echo $student['name']; ?></td></tr>
            <tr><th>Father's Name</th><td><?php echo $student['father_name']; ?></td></tr>
            <tr><th>Mother's Name</th><td><?php echo $student['mother_name']; ?></td></tr>
            <tr><th>Mobile</th><td><?php echo $student['mobile']; ?></td></tr>
            <tr><th>Email</th><td><?php echo $student['email']; ?></td></tr>
            <tr><th>Gender</th><td><?php echo $student['gender']; ?></td></tr>
            <tr><th>Caste</th><td><?php echo $student['caste']; ?></td></tr>
            <tr><th>Religion</th><td><?php echo $student['religion']; ?></td></tr>
        </table>
    </fieldset>

    <!-- Address Information -->
    <fieldset>
        <legend>Address (Present/Permanent)</legend>
        <table>
            <tr>
                <th>Present Address</th>
                <td><?php echo $student['present_address'] . ", " . $student['present_post'] . ", " . $student['present_block'] . ", " . $student['present_district'] . ", " . $student['present_state']; ?></td>
            </tr>
            <tr>
                <th>Permanent Address</th>
                <td><?php echo $student['permanent_address'] . ", " . $student['permanent_post'] . ", " . $student['permanent_block'] . ", " . $student['permanent_district'] . ", " . $student['permanent_state']; ?></td>
            </tr>
            <tr>
                <th>Country</th>
                <td><?php echo $student['country']; ?></td>
            </tr>
        </table>
    </fieldset>

    <!-- Educational Qualification -->
    <fieldset>
        <legend>Educational Qualification</legend>
        <table>
            <tr>
                <th>Class</th>
                <th>Board</th>
                <th>Institute Name</th>
                <th>Secure Mark</th>
                <th>Full Mark</th>
                <th>Percentage</th>
            </tr>
            <tr>
                <td>10th</td>
                <td><?php echo $student['board_10th']; ?></td>
                <td><?php echo $student['institute_10th']; ?></td>
                <td><?php echo $student['secure_mark_10th']; ?></td>
                <td><?php echo $student['full_mark_10th']; ?></td>
                <td><?php echo $student['percentage_10th']; ?>%</td>
            </tr>
            <tr>
                <td>Intermediate</td>
                <td><?php echo $student['board_intermediate']; ?></td>
                <td><?php echo $student['institute_intermediate']; ?></td>
                <td><?php echo $student['secure_mark_intermediate']; ?></td>
                <td><?php echo $student['full_mark_intermediate']; ?></td>
                <td><?php echo $student['percentage_intermediate']; ?>%</td>
            </tr>
            <tr>
                <td>Graduation</td>
                <td><?php echo $student['board_graduation']; ?></td>
                <td><?php echo $student['institute_graduation']; ?></td>
                <td><?php echo $student['secure_mark_graduation']; ?></td>
                <td><?php echo $student['full_mark_graduation']; ?></td>
                <td><?php echo $student['percentage_graduation']; ?>%</td>
            </tr>
        </table>
    </fieldset>

    <!-- Stream and Subject -->
    <fieldset>
        <legend>Applied Subject</legend>
        <table>
            <tr>
                <th>Stream</th>
                <td>
                    <?php
                    // Fetch stream name from the stream_id
                    $stream_query = "SELECT stream_name FROM streams WHERE id = ?";
                    $stmt = $conn->prepare($stream_query);
                    $stmt->bind_param("i", $student['stream_id']);
                    $stmt->execute();
                    $stream_result = $stmt->get_result();
                    $stream = $stream_result->fetch_assoc();
                    echo $stream['stream_name']; 
                    ?>
                </td>
            </tr>
            <tr>
                <th>Subject</th>
                <td>
                    <?php
                    // Fetch subject name from the subject_id
                    $subject_query = "SELECT subject_name FROM subjects WHERE id = ?";
                    $stmt = $conn->prepare($subject_query);
                    $stmt->bind_param("i", $student['subject_id']);
                    $stmt->execute();
                    $subject_result = $stmt->get_result();
                    $subject = $subject_result->fetch_assoc();
                    echo $subject['subject_name']; 
                    ?>
                </td>
            </tr>
        </table>
    </fieldset>
    
</div>

</body>
</html>

<?php
$conn->close();
?>
