<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include '../db/db_connect.php'; // Include your database connection file

// Get the student ID from the query parameter
$student_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($student_id <= 0) {
    echo "Invalid student ID.";
    exit();
}

// SQL query to fetch student details along with stream and subject names
$sql = "
    SELECT 
        s.id, 
        s.name, 
        s.father_name, 
        s.mother_name, 
        s.mobile, 
        s.email, 
        s.password, 
        s.gender, 
        s.caste, 
        s.religion, 
        s.present_address, 
        s.present_post, 
        s.present_block, 
        s.present_district, 
        s.present_state, 
        s.permanent_address, 
        s.permanent_post, 
        s.permanent_block, 
        s.permanent_district, 
        s.permanent_state, 
        s.country, 
        s.board_10th, 
        s.institute_10th, 
        s.secure_mark_10th, 
        s.full_mark_10th, 
        s.percentage_10th, 
        s.board_intermediate, 
        s.institute_intermediate, 
        s.secure_mark_intermediate, 
        s.full_mark_intermediate, 
        s.percentage_intermediate, 
        s.board_graduation, 
        s.institute_graduation, 
        s.secure_mark_graduation, 
        s.full_mark_graduation, 
        s.percentage_graduation, 
        st.stream_name, 
        sb.subject_name
    FROM students s
    LEFT JOIN streams st ON s.stream_id = st.id
    LEFT JOIN subjects sb ON s.subject_id = sb.id
    WHERE s.id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "No student found with this ID.";
    exit();
}

$student = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student Details</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Include your custom CSS file -->
</head>
<body>

<?php include 'header.php'; ?> <!-- Include header if you have one -->

<div class="main-content">
    <h2>Student Details</h2>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th colspan=6>Personal Information</th>
            </tr>
        </thead>
        <tbody>
            <tr><th colspan=2>Name</th><th colspan=2>Father's Name</th><th colspan=2>Mother's Name</th></tr>
			<tr><td colspan=2><?php echo htmlspecialchars($student['name']); ?></td>
			<td colspan=2><?php echo htmlspecialchars($student['father_name']); ?></td>
			<td colspan=2><?php echo htmlspecialchars($student['mother_name']); ?></td>
			</tr>
            <tr><th>Mobile</th><th>Email</th><th>Gender</th><th>Caste</th><th  colspan=2>Religion</th></tr>
			<td><?php echo htmlspecialchars($student['mobile']); ?></td>
			<td><?php echo htmlspecialchars($student['email']); ?></td>
			<td><?php echo htmlspecialchars($student['gender']); ?></td>
			<td><?php echo htmlspecialchars($student['caste']); ?></td>
			<td colspan=2><?php echo htmlspecialchars($student['religion']); ?></td>
            </tr>
			
			<tr>
                <th colspan=6>Address Information</th>
            </tr>
			<tr>
                <th colspan=6>Present Address</th>
            </tr>
			
            <tr><th>AT</th><th>POST</th><th>Town/City</th><th>District</th><th>State</th><th>Country</th></tr>
			<td><?php echo htmlspecialchars($student['present_address']); ?></td>
			<td><?php echo htmlspecialchars($student['present_post']); ?></td>
			<td><?php echo htmlspecialchars($student['present_block']); ?></td>
			<td><?php echo htmlspecialchars($student['present_district']); ?></td>
			<td><?php echo htmlspecialchars($student['present_state']); ?></td>
			<td><?php echo htmlspecialchars($student['country']); ?></td></tr>
			<tr>
                <th colspan=6>Permanent Address</th>
            </tr>
			
            <tr><th>AT</th><th>POST</th><th>Town/City</th><th>District</th><th>State</th><th>Country</th></tr>
			<td><?php echo htmlspecialchars($student['permanent_address']); ?></td>
			<td><?php echo htmlspecialchars($student['permanent_post']); ?></td>
			<td><?php echo htmlspecialchars($student['permanent_block']); ?></td>
			<td><?php echo htmlspecialchars($student['permanent_district']); ?></td>
			<td><?php echo htmlspecialchars($student['permanent_state']); ?></td>
			<td><?php echo htmlspecialchars($student['country']); ?></td></tr>
			
			<tr>
                <th colspan=6>Academic Information</th>
            </tr>
			<th>Class Name</th><th>Board Name</th><th>Institute Name</th><th>Secure Mark</th><th>Full Mark</th><th>Percentage</th></tr>
            <tr>
			<th>10th</th>
			<td><?php echo htmlspecialchars($student['board_10th']); ?></td>
            <td><?php echo htmlspecialchars($student['institute_10th']); ?></td>
            <td><?php echo htmlspecialchars($student['secure_mark_10th']); ?></td>
            <td><?php echo htmlspecialchars($student['full_mark_10th']); ?></td>
            <td><?php echo htmlspecialchars($student['percentage_10th']); ?></td></tr>
			
            <tr>
			<th>Intermediate (+2)</th>
			<td><?php echo htmlspecialchars($student['board_intermediate']); ?></td>
            <td><?php echo htmlspecialchars($student['institute_intermediate']); ?></td>
            <td><?php echo htmlspecialchars($student['secure_mark_intermediate']); ?></td>
            <td><?php echo htmlspecialchars($student['full_mark_intermediate']); ?></td>
            <td><?php echo htmlspecialchars($student['percentage_intermediate']); ?></td></tr>
			
			
            <tr>
			<td>Graduation</td>
			<td><?php echo htmlspecialchars($student['board_graduation']); ?></td>
            <td><?php echo htmlspecialchars($student['institute_graduation']); ?></td>
            <td><?php echo htmlspecialchars($student['secure_mark_graduation']); ?></td>
            <td><?php echo htmlspecialchars($student['full_mark_graduation']); ?></td>
            <td><?php echo htmlspecialchars($student['percentage_graduation']); ?></td></tr>
			
			<tr>
                <th colspan=6>Subject Taken</th>
            </tr>
			
            <tr><th colspan=3>Stream</th><th colspan=3>Subject</th></tr>
			<tr><td colspan=3><?php echo htmlspecialchars($student['stream_name']); ?></td>
				<td colspan=3><?php echo htmlspecialchars($student['subject_name']); ?></td></tr>
        </tbody>
    </table>
</div>

</body>
</html>

<?php
$stmt->close();
$conn->close(); // Close the database connection
?>
