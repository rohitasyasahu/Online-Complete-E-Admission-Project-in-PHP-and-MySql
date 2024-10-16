<?php
// Start session and check if admin is logged in
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include '../db/db_connect.php'; // Include the database connection
include 'header.php';
// Get the student ID from the URL
$student_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update student details
    $name = $_POST['name'];
    $father_name = $_POST['father_name'];
    $mother_name = $_POST['mother_name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $caste = $_POST['caste'];
    $religion = $_POST['religion'];
    $present_address = $_POST['present_address'];
    $present_post = $_POST['present_post'];
    $present_block = $_POST['present_block'];
    $present_district = $_POST['present_district'];
    $present_state = $_POST['present_state'];
    $permanent_address = $_POST['permanent_address'];
    $permanent_post = $_POST['permanent_post'];
    $permanent_block = $_POST['permanent_block'];
    $permanent_district = $_POST['permanent_district'];
    $permanent_state = $_POST['permanent_state'];
    $country = $_POST['country'];
    $board_10th = $_POST['board_10th'];
    $institute_10th = $_POST['institute_10th'];
    $secure_mark_10th = $_POST['secure_mark_10th'];
    $full_mark_10th = $_POST['full_mark_10th'];
    $percentage_10th = $_POST['percentage_10th'];
    $board_intermediate = $_POST['board_intermediate'];
    $institute_intermediate = $_POST['institute_intermediate'];
    $secure_mark_intermediate = $_POST['secure_mark_intermediate'];
    $full_mark_intermediate = $_POST['full_mark_intermediate'];
    $percentage_intermediate = $_POST['percentage_intermediate'];
    $board_graduation = $_POST['board_graduation'];
    $institute_graduation = $_POST['institute_graduation'];
    $secure_mark_graduation = $_POST['secure_mark_graduation'];
    $full_mark_graduation = $_POST['full_mark_graduation'];
    $percentage_graduation = $_POST['percentage_graduation'];
    $stream_id = $_POST['stream_id'];
    $subject_id = $_POST['subject_id'];

    // Update SQL query
    $sql = "UPDATE students SET 
            name = ?, 
            father_name = ?, 
            mother_name = ?, 
            mobile = ?, 
            email = ?,  
            gender = ?, 
            caste = ?, 
            religion = ?, 
            present_address = ?, 
            present_post = ?, 
            present_block = ?, 
            present_district = ?, 
            present_state = ?, 
            permanent_address = ?, 
            permanent_post = ?, 
            permanent_block = ?, 
            permanent_district = ?, 
            permanent_state = ?, 
            country = ?, 
            board_10th = ?, 
            institute_10th = ?, 
            secure_mark_10th = ?, 
            full_mark_10th = ?, 
            percentage_10th = ?, 
            board_intermediate = ?, 
            institute_intermediate = ?, 
            secure_mark_intermediate = ?, 
            full_mark_intermediate = ?, 
            percentage_intermediate = ?, 
            board_graduation = ?, 
            institute_graduation = ?, 
            secure_mark_graduation = ?, 
            full_mark_graduation = ?, 
            percentage_graduation = ?, 
            stream_id = ?, 
            subject_id = ? 
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssssssssssssssssssssssssssssssssssi', 
        $name, 
        $father_name, 
        $mother_name, 
        $mobile, 
        $email,  
        $gender, 
        $caste, 
        $religion, 
        $present_address, 
        $present_post, 
        $present_block, 
        $present_district, 
        $present_state, 
        $permanent_address, 
        $permanent_post, 
        $permanent_block, 
        $permanent_district, 
        $permanent_state, 
        $country, 
        $board_10th, 
        $institute_10th, 
        $secure_mark_10th, 
        $full_mark_10th, 
        $percentage_10th, 
        $board_intermediate, 
        $institute_intermediate, 
        $secure_mark_intermediate, 
        $full_mark_intermediate, 
        $percentage_intermediate, 
        $board_graduation, 
        $institute_graduation, 
        $secure_mark_graduation, 
        $full_mark_graduation, 
        $percentage_graduation, 
        $stream_id, 
        $subject_id, 
        $student_id
    );

    if ($stmt->execute()) {
        echo "<script>alert('Student details updated successfully.');</script>";
    } else {
        echo "<script>alert('Error updating student details: " . $stmt->error . "');</script>";
    }
}

// Fetch current student details for pre-filling the form
$sql = "SELECT * FROM students WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $student_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if (!$student) {
    echo "Student not found.";
    exit();
}

// Fetch streams and subjects for dropdowns
$streams_sql = "SELECT id, stream_name FROM streams";
$streams_result = $conn->query($streams_sql);

$subjects_sql = "SELECT id, subject_name FROM subjects";
$subjects_result = $conn->query($subjects_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
</head>
<body>

<div class="main-content">
    <h2>Edit Student Information</h2>
	<table>
        <thead>
            <tr>
                <th colspan=4>Edit Personal Information</th>
            </tr>
        </thead>
		<tr>
		<th>Name</th><th>Father's Name</th><th>Mother's Name</th><th>Mobile</th></tr>
    <form method="POST">
	<tr>
    <td><input type="text" name="name" placeholder="Name" value="<?php echo htmlspecialchars($student['name']); ?>" required></td>
    <td><input type="text" name="father_name" placeholder="Father's Name" value="<?php echo htmlspecialchars($student['father_name']); ?>" required></td>
    <td><input type="text" name="mother_name" placeholder="Mother's Name" value="<?php echo htmlspecialchars($student['mother_name']); ?>" required></td>
     <td><input type="text" name="mobile" placeholder="Mobile" value="<?php echo htmlspecialchars($student['mobile']); ?>" required></td>
     </tr>
	<tr><th>Email</th><th>Gender</th><th>Caste</th><th>Religion</th></tr>
        <td><input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($student['email']); ?>" required></td>
    <td><select name="gender" required>
            <option value="Male" <?php if($student['gender'] == 'Male') echo 'selected'; ?>>Male</option>
            <option value="Female" <?php if($student['gender'] == 'Female') echo 'selected'; ?>>Female</option>
        </select></td>
        
    <td><input type="text" name="caste" placeholder="Caste" value="<?php echo htmlspecialchars($student['caste']); ?>" required></td>
    <td><input type="text" name="religion" placeholder="Religion" value="<?php echo htmlspecialchars($student['religion']); ?>" required></td></tr>
	</tr>
	<tr>
        <th colspan=4>Edit Present Address</th>
    </tr>
		<th>AT</th><th>POST</th><th>BLOCK/TOWN</th><th>DISTRICT</th></tr><tr>
		<td><input type="text" name="present_address" placeholder="Present Address" required value="<?php echo htmlspecialchars($student['present_address']); ?>"</textarea></td>
        <td><input type="text" name="present_post" placeholder="Present Post" value="<?php echo htmlspecialchars($student['present_post']); ?>" required></td>
        <td><input type="text" name="present_block" placeholder="Present Block" value="<?php echo htmlspecialchars($student['present_block']); ?>" required></td>
        <td><input type="text" name="present_district" placeholder="Present District" value="<?php echo htmlspecialchars($student['present_district']); ?>" required></td></tr>
    <tr><th>State</th><th>Country</th></tr>
		<td><input type="text" name="present_state" placeholder="Present State" value="<?php echo htmlspecialchars($student['present_state']); ?>" required></td>
        <td><input type="text" name="country" placeholder="Country" value="<?php echo htmlspecialchars($student['country']); ?>" required></td></tr>
	<tr>
        <th colspan=4>Edit Permanent Address</th>
    </tr>	
		<th>AT</th><th>POST</th><th>BLOCK/TOWN</th><th>DISTRICT</th></tr><tr>
    <td><input type="text" name="permanent_address" placeholder="Permanent Address" required value="<?php echo htmlspecialchars($student['permanent_address']); ?>"</textarea></td>
    <td><input type="text" name="permanent_post" placeholder="Permanent Post" value="<?php echo htmlspecialchars($student['permanent_post']); ?>" required></td>
    <td><input type="text" name="permanent_block" placeholder="Permanent Block" value="<?php echo htmlspecialchars($student['permanent_block']); ?>" required></td>
    <td><input type="text" name="permanent_district" placeholder="Permanent District" value="<?php echo htmlspecialchars($student['permanent_district']); ?>" required></td></tr>
    <tr>
	<th>State</th><th>Country</th></tr>
	<tr>
	<td><input type="text" name="permanent_state" placeholder="Permanent State" value="<?php echo htmlspecialchars($student['permanent_state']); ?>" required></td>
	<td><input type="text" name="country" placeholder="Country" value="<?php echo htmlspecialchars($student['country']); ?>" required></td></tr>
    </table>
	
	<table>
	<tr>
    <th colspan=6>Edit Educational Qualification</th>
    </tr>
	<th>Class</th><th>Board/University</th><th>Institute Name</th><th>Secure Mark</th><th>Full Mark</th><th>Percentage</th></tr>
    <tr>
		<th>10th</th>
		<td><input type="text" name="board_10th" placeholder="Board 10th" value="<?php echo htmlspecialchars($student['board_10th']); ?>" required></td>
        <td><input type="text" name="institute_10th" placeholder="Institute 10th" value="<?php echo htmlspecialchars($student['institute_10th']); ?>" required></td>
        <td><input type="number" name="secure_mark_10th" placeholder="Secure Mark 10th" value="<?php echo htmlspecialchars($student['secure_mark_10th']); ?>" required></td>
        <td><input type="number" name="full_mark_10th" placeholder="Full Mark 10th" value="<?php echo htmlspecialchars($student['full_mark_10th']); ?>" required></td>
        <td><input type="number" name="percentage_10th" placeholder="Percentage 10th" value="<?php echo htmlspecialchars($student['percentage_10th']); ?>" required></td></tr>
    
	
		<tr><th>12th/Intermediate</th>
		<td><input type="text" name="board_intermediate" placeholder="Board Intermediate" value="<?php echo htmlspecialchars($student['board_intermediate']); ?>" required></td>
        <td><input type="text" name="institute_intermediate" placeholder="Institute Intermediate" value="<?php echo htmlspecialchars($student['institute_intermediate']); ?>" required></td>
        <td><input type="number" name="secure_mark_intermediate" placeholder="Secure Mark Intermediate" value="<?php echo htmlspecialchars($student['secure_mark_intermediate']); ?>" required></td>
        <td><input type="number" name="full_mark_intermediate" placeholder="Full Mark Intermediate" value="<?php echo htmlspecialchars($student['full_mark_intermediate']); ?>" required></td>
        <td><input type="number" name="percentage_intermediate" placeholder="Percentage Intermediate" value="<?php echo htmlspecialchars($student['percentage_intermediate']); ?>" required></td></tr>
        
		<tr><th>Graduation</th>
        <td><input type="text" name="board_graduation" placeholder="Board Graduation" value="<?php echo htmlspecialchars($student['board_graduation']); ?>" required></td>
        <td><input type="text" name="institute_graduation" placeholder="Institute Graduation" value="<?php echo htmlspecialchars($student['institute_graduation']); ?>" required></td>
        <td><input type="number" name="secure_mark_graduation" placeholder="Secure Mark Graduation" value="<?php echo htmlspecialchars($student['secure_mark_graduation']); ?>" required></td>
        <td><input type="number" name="full_mark_graduation" placeholder="Full Mark Graduation" value="<?php echo htmlspecialchars($student['full_mark_graduation']); ?>" required></td>
        <td><input type="number" name="percentage_graduation" placeholder="Percentage Graduation" value="<?php echo htmlspecialchars($student['percentage_graduation']); ?>" required></td></tr>
		</table>
		
		<table>
		<tr>
		<th colspan=3>Edit Course Information</th></tr><tr>
		<th>Select Stream</th><th>Select Subject</th></tr>
        <tr><td><select name="stream_id" required>
            <option value="">Select Stream</option>
            <?php while ($stream = $streams_result->fetch_assoc()): ?>
                <option value="<?php echo $stream['id']; ?>" <?php if($student['stream_id'] == $stream['id']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($stream['stream_name']); ?>
                </option>
            <?php endwhile; ?>
        </select></td>
		<td>
        <select name="subject_id" required>
            <option value="">Select Subject</option>
            <?php while ($subject = $subjects_result->fetch_assoc()): ?>
                <option value="<?php echo $subject['id']; ?>" <?php if($student['subject_id'] == $subject['id']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($subject['subject_name']); ?>
                </option>
            <?php endwhile; ?>
        </select></tr></td>
        <tr><td colspan=2>
        <button type="submit">Update Student</button></td></tr>
    </form>
</div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
